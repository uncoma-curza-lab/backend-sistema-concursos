<?php

namespace app\helpers;

use app\models\ContestAttachedFile;
use app\models\VeredictContestAttachedFile;

class ContestAttachedFilesFactory
{

    public static function instantiate(array $data) : ContestAttachedFile
    {        
        if (!$data){
            return new ContestAttachedFile();
        }
        $documentTypeId = (int) $data['ContestAttachedFile']['document_type_id'];
        $file = self::getInstance($documentTypeId);
        
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
