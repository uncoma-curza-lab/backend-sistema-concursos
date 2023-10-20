<?php

namespace app\controllers;

use app\helpers\PersonalFilesFactory;
use app\models\DocumentType;
use app\models\PersonalFile;
use app\models\PostulationFile;
use Yii;
use yii\data\ActiveDataProvider;
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

        $filesQuery = PersonalFile::find()->loggedUser();
        $files = new ActiveDataProvider(['query' => $filesQuery]);

        return $this->render('user_files', [
            'files' => $files,
        ]);

    }

    public function actionUploadFile(int | null $postulationId = null)
    {
        $model = PersonalFilesFactory::instantiate($postulationId);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->person_id = Yii::$app->user->identity->person->id;
            $model->postulation_id = $postulationId;
            $model->created_at = date('Y-m-d H:i:s');
            $file = UploadedFile::getInstanceByName('file');
            if($file){
                if ($model->upload($file)) {
                    return $this->redirect($model->getFilesUrl());
                }
            }else{
                \Yii::$app->session->setFlash('error', 'Seleccione un Archivo');
            }
        }

        return $this->render('upload_file', array_merge([
                'modelForm' => $model,
            ], $this->getProps($model))
        );

    }

    public function actionPostulationFiles(int $postulationId)
    {
        $filesQuery = PostulationFile::find()->postulation_files($postulationId);
        $files = new ActiveDataProvider(['query' => $filesQuery]);

        return $this->render('/postulations/postulation_files', [
            'files' => $files,
            'postulationId' => $postulationId
        ]);
    }

    public function actionDelete(int $fileId)
    {
        $model = $this->findModel($fileId);
        if(!$model->delete()){
            \Yii::$app->session->setFlash('error', 'No se pudo borrar del Archivo');
        }
        $this->redirect($model->getFilesUrl());
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
