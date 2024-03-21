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

}
