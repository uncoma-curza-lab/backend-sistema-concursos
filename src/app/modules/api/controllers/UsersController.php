<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class UsersController extends ActiveController
{
    public $modelClass = 'app\models\Users';
}
