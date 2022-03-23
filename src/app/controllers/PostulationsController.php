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
                        'actions' => ['download-pdf'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if (!\Yii::$app->user->identity->isValid()) {
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

        return $this->renderPartial('/postulations/inscription', [
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
        $contest = $postulation->contest;
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('postulationPdf',[
            'postulation' => $postulation,
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
}
