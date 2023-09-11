<?php

namespace app\controllers;

use app\models\DocumentType;
use app\models\PersonalFile;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use \yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class PersonalFileController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMyFiles()
    {

        $files = PersonalFile::find()->loggedUser()->all();

        return $this->render('user_files', [
            'files' => $files,
        ]);

    }

    public function actionUploadFile()
    {
        $model = new PersonalFile();
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->person_id = Yii::$app->user->identity->person->id;
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->upload(UploadedFile::getInstanceByName('file'))) {
                return $this->redirect(['my-files']);
            }
        }

        return $this->render('upload_file', [
            'modelForm' => $model,
            'documentsTypeList' => ArrayHelper::map(DocumentType::find()->all(), 'code', 'name')
        ]);

    }

    public function actionPostulationFiles(int $postulationId)
    {
        $files = PersonalFile::find()->postulation_files($postulationId)->all();

        return $this->render('/postulations/postulation_files', [
            'files' => $files,
        ]);
    }

    public function actionDelete(int $fileId)
    {
        if(!$this->findModel($fileId)->delete()){
            \Yii::$app->session->setFlash('error', 'No se pudo borrar del Archivo');
        }
        $this->redirect('my-files');
    }

    protected function findModel(int $id)
    {
        if (($model = PersonalFile::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }

}
