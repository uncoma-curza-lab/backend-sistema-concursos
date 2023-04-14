<?php

namespace app\modules\backoffice\models;

use app\models\ContestAttachedFile;
use app\models\Contests;

class DeleteContestAttachFileProcess {

    private $attachFile;
    private $contest;

    public function __construct(ContestAttachedFile $attachFile, Contests $contest)
    {
        $this->attachFile = $attachFile;
        $this->contest = $contest;
    }

    public function handle() : bool
    {
        if(\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $this->contest->code])){
            if(!$this->attachFile->isVeredict()){
                \Yii::$app->session->setFlash('error', 'No tiene permisos para eliminar este archivo');
                return false;
            }
        }

        if (!$this->attachFile->delete()) {
            \Yii::$app->session->setFlash('error', 'No se pudo borrar del Archivo');
            return false;
        }

        return true;
    }
}
