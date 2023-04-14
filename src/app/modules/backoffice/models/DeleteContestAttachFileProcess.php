<?php

namespace app\modules\backoffice\models;

use app\models\ContestAttachedFile;

class DeleteContestAttachFileProcess {

    private $attachFile;

    public function __construct(ContestAttachedFile $attachFile)
    {
        $this->attachFile = $attachFile;
    }

    public function handle() : bool
    {
        $slug = $this->attachFile->contest->code;
        if(\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $slug])){
            if(!$this->attachFile->isVeredict()){
                return false;
            }
        }

        if (!$this->attachFile->delete()) {
            return false;
        }

        return true;
    }
}
