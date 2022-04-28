<?php

namespace app\modules\api\controllers;

use app\models\Career;
use yii\web\Controller;

class CareersController extends Controller
{
    public function actionAll()
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $departments = Career::all();
        $response->statusCode = 200;

        return $departments;
    }

    public function actionOne($id)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $department = Career::find($id);
        $response->statusCode = 200;

        return 
            $department
        ;
    }

    public function actionDepartments($id)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $department = Career::findByDepartament($id);
        $response->statusCode = 200;

        return 
            $department
        ;
    }
}
