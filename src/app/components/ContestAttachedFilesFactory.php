<?php

namespace app\components;

use app\models\ContestAttachedFile;
use app\models\VeredictContestAttachedFile;

class ContestAttachedFilesFactory
{

    public static function instantiate(array $data) : ContestAttachedFile
    {        
        if (!isset($data['ContestAttachedFile'])){
            throw new \Throwable("Error: ContestAttachedFile not set");
        }
        $data['VeredictContestAttachedFile'] = $data['ContestAttachedFile'];
        $documentTypeId = (int) $data['ContestAttachedFile']['document_type_id'];
        $file = self::getInstance($documentTypeId);
        $file->load($data);
        
        return $file;
    }

    private static function getInstance(int $documentTypeId) : ContestAttachedFile
    {
        return $documentTypeId === \Yii::$app->veredictDocumentTypeSingleton->getDocumentType()->id 
            ? 
            new VeredictContestAttachedFile() 
            : 
            new ContestAttachedFile();
    }
}
