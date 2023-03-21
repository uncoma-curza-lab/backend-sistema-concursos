<?php

namespace app\modules\backoffice\controllers;

use app\helpers\ContestAttachedFilesFactory;
use app\models\ContestAttachedFile;
use app\models\Contests;
use app\models\DocumentResponsible;
use app\models\DocumentType;
use app\models\InscribedContestAttachedFileForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ContestAttachedFilesController extends \yii\web\Controller
{
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
        $modelForm = new InscribedContestAttachedFileForm();
        if ($this->request->isPost && $modelForm->load($this->request->post())) {
                return $this->redirect(['/backoffice/contest/view/'.$slug]);
        }

        return $this->render('generate_inscribed_file', [
            'contest' => $contest,
            'modelForm' => $modelForm,
        ]);
    }

    private function getProps(Contests $contest)
    {
        $documentsTypes = [];
        $responsibles = [];
        $adminRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin');
        $teacher_departmentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament');
        $presidentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $contest->code]);

        if($adminRol || $teacher_departmentRol){
            if($contest->isRegular()){
                $documentsTypes = DocumentType::find()->forRegularContest()->all(); 
            }else{
                $documentsTypes = DocumentType::find()->forNotRegularContest()->all(); 
            }
            $responsibles = DocumentResponsible::find()->all();
        }else if ($presidentRol) {
            $documentsTypes = DocumentType::find()->forPresident()->all(); 
            $responsibles = DocumentResponsible::find()->forPresident()->all();
        }

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
