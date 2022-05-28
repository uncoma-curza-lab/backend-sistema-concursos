<?php

namespace app\controllers;

use app\models\Contests;
use app\models\InscriptionForm;
use app\models\Postulations;
use app\models\search\MyPostulationsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use kartik\mpdf\Pdf;
use yii\web\HttpException;

class PostulationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['contest-inscription'],
                        'roles' => ['postulateToContest'],
                        'roleParams' => function() {
                            return [
                                'contestSlug' => Yii::$app->request->get('slug'),
                            ];
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['my-postulations'],
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return \Yii::$app->user->identity->isValid();
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['download-pdf', 'postulation-files'],
                        'roles' => ['postulateToContest'],
                        'roleParams' => function() {
                            return [
                                'contestSlug' => Yii::$app->request->get('slug'),
                            ];
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['download-resolution'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if (!\Yii::$app->user || !\Yii::$app->user->identity || !\Yii::$app->user->identity->isValid()) {
                        \Yii::$app->cache->set('error', [
                            'message' => 'Debe completar los datos del perfil antes de inscribirse',
                        ]);

                        return $this->redirect([
                            'user/profile',
                        ]);
                    }
                    throw new \yii\web\ForbiddenHttpException('No tiene permisos');

                },
            ],
        ];
    }

    public function actionDownloadResolution($slug)
    {
        $model= Contests::find()->onlyPublic()
                                ->getBySlug($slug);
        if (!$model->isResolutionPublished()) {
            throw new HttpException(403, 'No se ha encontrado la resolución');
        }

        $filepath = $model->getResolutionPath();
        if ($filepath) {
            return Yii::$app->response->sendFile($filepath);
        }
        return $this->redirect(['index']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionContestInscription($slug)
    {

        $contest = Contests::find()->onlyPublic()
                                   ->getBySlug($slug);

        $person = \Yii::$app->user->identity->person;

        if ($person->isPostulatedInContest($contest->id)) {
            $this->redirect(Url::toRoute('postulations/my-postulations'));
        }

        $inscriptionForm = new InscriptionForm();
        $inscriptionForm->contest = $contest;

        if ($inscriptionForm->load(Yii::$app->request->post())) {
            if ($inscriptionForm->save()) {
                $this->redirect(Url::toRoute('postulations/my-postulations'));
            }
        }

        return $this->renderAjax('/postulations/inscription', [
            'contest' => $contest,
            'inscriptionForm' => $inscriptionForm,
        ]);
    }

    public function actionMyPostulations()
    {
        $searchModel = new MyPostulationsSearch();
        $dataProvider = $searchModel->search(array_merge(
            [
                'person_id' => Yii::$app->user->identity->person->id
            ],
            $this->request->queryParams
        ));

        return $this->render('my_postulations', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadPdf($postulationId){
        
        $postulation = Postulations::findOne($postulationId);
        $user = Yii::$app->user;
        if (!$user || !$user->identity || $user->identity->person->id !== $postulation->person_id) {
            throw new HttpException(401, 'Verifique la solicitud nuevamente');
        }
        $contest = $postulation->contest;
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('postulationPdf',[
            'postulation' => $postulation,
            'person' => $user->identity->person,
            'contest' => $contest
        ]);
        
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, 
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            'options' => ['title' => 'Comprobante de Postulación'],
            'methods' => [ 
                'SetHeader'=>['Universidad Nacional Del Comahue'],
            ]
        ]);
        
        return $pdf->render(); 
        
    }

    public function actionPostulationFiles($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);

        $response = $postulation->getPostulationFolderShare();

        if($response['code'] == 100){
            $shareUrl = $response['url'];
            $shareUrl = str_replace($_ENV['NEXTCLOUD_URL'], $_ENV['NEXTCLUD_ALTERNATIVE_URL'], $shareUrl);
            return $this->render('postulation_files', [
                'shareUrl' => $shareUrl,
            ]);
        }
        
        return $this->render('postulation_files');
    }
}
