<?php

namespace app\modules\backoffice\controllers;

use app\helpers\ContestAttachedFilesFactory;
use app\models\ContestAttachedFile;
use app\models\Contests;
use app\models\DocumentResponsible;
use app\models\DocumentType;
use app\models\InscribedContestAttachedFile;
use app\models\InscribedContestAttachedFileForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ContestAttachedFilesController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin'],
                            'actions' => ['attach-file', 'publish', 'delete', 'generate-inscribed-file', 'inscribed-preview'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['attach-file'],
                            'roles' => ['uploadResolution'],
                            'roleParams' => function() {
                                return [
                                    'contestSlug' => Yii::$app->request->get('slug'),
                                ];
                            },
                        ],
                     ],
                ],
            ],
        );
    }

    public function actionAttachFile($slug)
    {
        $contest = Contests::find()->findBySlug($slug);
        $model = ContestAttachedFilesFactory::instantiate($this->request->post());
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->contest_id = $contest->id;
            $model->created_at = date('Y-m-d H:i:s');
            $model->resolution_file = UploadedFile::getInstance($model, 'resolution_file');

            if ($model->upload()) {
                return $this->redirect(['/backoffice/contest/view/'.$slug]);
            }
        }

        return $this->render('upload_attached_file', array_merge([
            'contest' => $contest,
            'modelForm' => $model,
        ], $this->getProps($contest)));

    }

    public function actionPublish(int $fileId, string $slug)
    {
        $model = $this->findModel($fileId);
        if (!$model->changePublishedStatus()){
            \Yii::$app->session->setFlash('error', 'No se pudo cambiar el estado del Archivo');
        }
        return $this->redirect('/backoffice/contest/view/' . $slug . '#attached_files');
    }

    public function actionDelete(int $fileId, string $slug)
    {
        $model = $this->findModel($fileId);
        if (!$model->delete()) {
            \Yii::$app->session->setFlash('error', 'No se pudo borrar del Archivo');
        }
        return $this->redirect('/backoffice/contest/view/' . $slug . '#attached_files');
    }

    public function actionGenerateInscribedFile(string $slug)
    {
        $contest = Contests::find()->findBySlug($slug);
        if($contest->getInscribedPostualtion()){
            \Yii::$app->session->setFlash('error', 'Ya existe una Nomina de inscriptos');
            return $this->redirect('/backoffice/contest/view/' . $slug . '#attached_files');
        }
        $modelForm = new InscribedContestAttachedFileForm();
        if ($this->request->isPost && $modelForm->load($this->request->post())) {
            $modelForm->save($contest->id);
            return $this->redirect(['/backoffice/contest/view/'.$slug]);
        }

        $content = $this->renderPartial('inscribed_file_pdf',[
            'contest' => $contest
        ]);

        return $this->render('generate_inscribed_file', [
            'contest' => $contest,
            'content' => $content,
            'modelForm' => $modelForm,
        ]);
    }

    public function actionInscribedPreview()
    {
        header('Content-type: application/pdf');
        $data = \Yii::$app->request->post();
        $pdf = InscribedContestAttachedFile::writePdf($data['text']);

        return $pdf->Output();
    }

    private function getProps(Contests $contest)
    {
        $documentsTypesQuery = DocumentType::find();
        $responsiblesQuery = DocumentResponsible::find();
        $adminRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin');
        $teacher_departmentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament');
        $presidentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $contest->code]);

        if($adminRol || $teacher_departmentRol){
            if($contest->isRegular()){
                $documentsTypesQuery->forRegularContest(); 
            }else{
                $documentsTypesQuery->forNotRegularContest(); 
            }
        }else if ($presidentRol) {
            $documentsTypesQuery->forPresident(); 
            $responsiblesQuery->forPresident();
        }

        $documentsTypes = $documentsTypesQuery->all();
        $responsibles = $responsiblesQuery->all();

        $documentsTypeList = ArrayHelper::map($documentsTypes, 'id', 'name');
        $responsiblesList = ArrayHelper::map($responsibles, 'id', 'name');
        return [
            'documentsTypeList' => $documentsTypeList,
            'responsiblesList' => $responsiblesList
        ];
    }

    protected function findModel(int $id)
    {
        if (($model = ContestAttachedFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }

}
