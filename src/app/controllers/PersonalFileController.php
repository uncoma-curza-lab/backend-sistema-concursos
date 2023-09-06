<?php

namespace app\controllers;

use app\models\PersonalFile;
use \yii\web\Controller;

class PersonalFileController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMyFiles()
    {

        $files = PersonalFile::find()->loggedUser()->all();

        return $this->render('my_files', [
            'files' => $files,
        ]);

    }

    public function actionPostulationFiles(int $postulationId)
    {
        return $this->render('index');
    }

}
