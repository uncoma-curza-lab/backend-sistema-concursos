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
            $modelForm->resolution_file = UploadedFile::getInstance($modelForm, 'resolution_file');
            if ($modelForm->upload()) {
                return $this->redirect(['/backoffice/contest/view/'.$slug]);
            }
        }

        return $this->render('upload_attached_file', array_merge([
            'contest' => $contest,
            'modelForm' => $modelForm,
        ], $this->getProps()));

    }

    public function actionPublish(int $fileId, string $slug)
    {
        $model = $this->findModel($fileId);
        $model->changePublishedStatus();
        return $this->redirect('/backoffice/contest/view/' . $slug . '#attached_files');
    }

    public function actionDelete(int $fileId, string $slug)
    {
        //TODO - Remove file
        $model = $this->findModel($fileId);
        $model->delete();
        return $this->redirect('/backoffice/contest/view/' . $slug . '#attached_files');
    }


    private function getProps()
    {
        $documentsTypeList = ArrayHelper::map(DocumentType::find()->all(), 'id', 'name');
        $responsiblesList = ArrayHelper::map(DocumentResponsible::find()->all(), 'id', 'name');
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
