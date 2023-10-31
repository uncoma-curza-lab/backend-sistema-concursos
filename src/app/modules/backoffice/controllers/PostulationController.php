<?php

namespace app\modules\backoffice\controllers;

use app\models\Contests;
use app\models\PersonalFile;
use app\models\Postulations;
use app\models\PostulationStatus;
use app\models\search\PersonalFileSearch;
use app\modules\backoffice\models\PersonalFileValidationForm;
use app\modules\backoffice\searchs\PostulationsByContestSearch;
use app\useCases\ValidateFileProcess;
use Exception;
use InvalidArgumentException;
use Mpdf\Container\NotFoundException;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class PostulationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'approve' => ['POST'],
                        'reject' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['viewImplicatedPostulations'],
                            'actions' => ['contest', 'show'],
                            'roleParams' => function() {
                                return [
                                    'contestSlug' => Yii::$app->request->get('slug'),
                                ];
                            },
                        ],
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin'],
                            'actions' => ['approve', 'contest', 'reject', 'show'],
                        ],
                    ]
                ],
            ],
        );
    }

    public function actionContest($slug)
    {
        $contest = $this->findContest($slug);
        $searchModel = new PostulationsByContestSearch($slug);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/contest/contest_details', [
            'view' => '/postulation/_postulations_by_contest',
            'params' => [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'contest' => $contest,
                'model' => $contest
            ],
        ]);
    }

    public function actionApprove($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $postulation->status = PostulationStatus::ACCEPTED;
        $postulation->save();
        return $this->redirect(['contest', 'slug' => $postulation->contest->code]);
    }

    public function actionReject($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $postulation->status = PostulationStatus::REJECTED;
        $postulation->save();
        return $this->redirect(['contest', 'slug' => $postulation->contest->code]);
    }

    public function actionShow($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $person = $postulation->person;
        $filesSearch = new PersonalFileSearch();
        $files = $filesSearch->searchPersonalAndPostulation($postulation->id, $person->id);
        if(Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'jury')){
            $files->query->onlyValid();
        }
        $validationForm = false;
        $canValidate = Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'admin')
           ||
           Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'teach_departament');

        if($canValidate){
            $validationForm = new PersonalFileValidationForm();
            if ($this->request->isPost && $validationForm->load($this->request->post())) {
                $process = new ValidateFileProcess($validationForm);
                try {
                    $process->handle();
                    Yii::$app->session->setFlash('success', 'Archivo validado con exito');
                    return $this->redirect(['show', 'postulationId' => $postulation->id]);
                } catch (ForbiddenHttpException $ex) {
                    Yii::$app->session->setFlash('error', $ex->getMessage());
                } catch (InvalidArgumentException $ex) {
                    Yii::$app->session->setFlash('error', 'Corrija los errores');
                } catch (NotFoundException $ex) {
                    Yii::$app->session->setFlash('error', $ex->getMessage());
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('error', $ex->getMessage());
                }
    
            }
        }

        return $this->render('show', [
            'profile' => $person,
            'postulation' => $postulation,
            'files' => $files,
            'validationForm' => $validationForm,
            'canValidate' => $canValidate,
        ]);
    }

    public function actionTest()
    {
        var_dump(\Yii::$app->user->can('postulateToContest'));
        die();
    }

    private function findContest(string $slug)
    {
        return Contests::find()->findBySlug($slug);
    }
}
