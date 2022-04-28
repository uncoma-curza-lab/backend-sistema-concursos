<?php

namespace app\modules\api\controllers;

use yii\base\Controller;

//use yii\rest\ActiveController;

class HealthCheckController extends Controller
{
    public function actionIndex()
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;

        return [
            'message' => 'OK',
            'status_code' => $response->statusCode,
        ];
    }

}
