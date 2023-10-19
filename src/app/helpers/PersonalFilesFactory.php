<?php

namespace app\helpers;

use app\models\PersonalFile;
use app\models\PostulationFile;

class PersonalFilesFactory
{

    public static function instantiate(int | null $postulationId = null) : PersonalFile
    {        
        if (!$postulationId){
            return new PersonalFile();
        }
        
        return new PostulationFile();
    }

    public static function findOne(int $id) : PersonalFile | null
    {        
        $model = PersonalFile::findOne($id);

        if(!$model->postulation_id){
            return $model;
        }
        
        return PostulationFile::findOne($id);
    }

}
