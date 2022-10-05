<?php

namespace app\controllers;

use app\components\NotificationComponent;
use app\events\NotificationEvent;
use app\models\Contests;
use app\models\Notification;
use app\models\User;
use yii\base\Event;
use yii\web\Controller;

class NotificationTestController extends Controller
{
    public function actionIndex()
    {
        $contest = Contests::find()->one();
        $contest->publishResolution();
    }
}
