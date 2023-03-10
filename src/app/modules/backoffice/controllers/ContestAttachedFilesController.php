<?php

namespace app\modules\backoffice\controllers;

class ContestAttachedFilesController extends \yii\web\Controller
{
    public function actionAttachFile($slug)
    {
        return $this->render('index', ['slug' => $slug]);
    }

}
