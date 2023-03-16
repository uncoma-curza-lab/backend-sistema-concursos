<?php

namespace app\modules\backoffice\controllers;

use app\models\ContestAttachedFile;
use app\models\Contests;
use app\models\DocumentResponsible;
use app\models\DocumentType;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ContestAttachedFilesController extends \yii\web\Controller
{
    public function actionAttachFile($slug)
    {
        $contest = Contests::find()->findBySlug($slug);
        $modelForm = new ContestAttachedFile();
        if ($this->request->isPost && $modelForm->load($this->request->post())) {
            $modelForm->contest_id = $contest->id;
            $modelForm->created_at = date('Y-m-d H:i:s');
            $modelForm->resolution_file = UploadedFile::getInstance($modelForm, 'resolution_file');
            if($modelForm->isVeredict()){
                if ($modelForm->uploadVeredict()){
                    return $this->redirect(['/backoffice/contest/index']);
                }
            }

            if ($modelForm->upload()) {
                return $this->redirect(['/backoffice/contest/view/'.$slug]);
            }
        }

        return $this->render('upload_attached_file', array_merge([
            'contest' => $contest,
            'modelForm' => $modelForm,
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
