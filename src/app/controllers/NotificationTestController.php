<?php

namespace app\controllers;

use app\components\NotificationComponent;
use yii\web\Controller;

class NotificationTestController extends Controller
{
    public function actionIndex()
    {
        $notifiaction = new NotificationComponent();
        $notifiaction->publishResolution([]);

    }
}
