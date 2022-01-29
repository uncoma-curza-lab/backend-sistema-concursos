<?php

namespace app\controllers\interfaces;

use Yii;
use yii\web\Controller;

abstract class SCController extends Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->person) {
            $this->redirect(array('user/profile'));
        }
        return true;
    }
}
