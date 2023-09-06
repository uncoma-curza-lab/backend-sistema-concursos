<?php

namespace app\controllers;

use \yii\web\Controller;

class PersonalFileController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}
