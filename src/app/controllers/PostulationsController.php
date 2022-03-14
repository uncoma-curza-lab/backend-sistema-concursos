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

use function Safe\file_get_contents;

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
                        /*
                        'roleParams' => function() {
                            return [
                                'contestSlug' => Yii::$app->request->get('slug'),
                            ];
                        },*/
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

        return $this->render('/postulations/inscription', [
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
        /*
        ob_start();
        include ("postulationPdf.php");
        $content=ob_get_contents();
        ob_end_clean();
        */

        $content = $this->renderPartial('postulationPdf',[
            'postulation' => $postulation,
            'contest' => $contest
        ]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            // set mPDF properties on the fly
            'options' => ['title' => 'Comprobante de Postulación'],
            // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Universidad Nacional Del Comahue'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
        
    }
}
