<?php

namespace app\modules\backoffice\controllers;

use app\models\ContestAttachedFile;
use app\models\Contests;
use app\models\DocumentResponsible;
use app\models\DocumentType;
use yii\helpers\ArrayHelper;
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
                // file is uploaded successfully
                return $this->redirect(['/backoffice/contest/view/'.$slug]);
            }
        }

        return $this->render('upload_attached_file', array_merge([
            'contest' => $contest,
            'modelForm' => $modelForm,
        ], $this->getProps()));

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

}
