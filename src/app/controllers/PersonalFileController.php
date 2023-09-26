<?php

namespace app\controllers;

use app\helpers\PersonalFilesFactory;
use app\models\DocumentType;
use app\models\PersonalFile;
use app\models\PostulationFile;
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

    public function actionUploadFile(int | null $postulationId = null)
    {
        //TODO: Diferenciar personal file o postulation file
        //¿Armar un Factory?
        $model = PersonalFilesFactory::instantiate($postulationId);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->person_id = Yii::$app->user->identity->person->id;
            $model->postulation_id = $postulationId;
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->upload(UploadedFile::getInstanceByName('file'))) {
                return $this->redirect($model->getFilesUrl());
            }
        }

        return $this->render('upload_file', array_merge([
                'modelForm' => $model,
            ], $this->getProps($model))
        );

    }

    public function actionPostulationFiles(int $postulationId)
    {
        $files = PostulationFile::find()->postulation_files($postulationId)->all();

        return $this->render('/postulations/postulation_files', [
            'files' => $files,
            'postulationId' => $postulationId
        ]);
    }

    public function actionDelete(int $fileId)
    {
        if(!$this->findModel($fileId)->delete()){
            \Yii::$app->session->setFlash('error', 'No se pudo borrar del Archivo');
        }
        $this->redirect('my-files');
    }

    protected function getProps(PersonalFile $file)
    {
        $documentsTypeList = ArrayHelper::map($file->getDocumentsTypes(), 'code', 'name');

        return [
            'documentsTypeList' => $documentsTypeList
        ];
    }

    protected function findModel(int $id)
    {
        if (($model = PersonalFile::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }

}
