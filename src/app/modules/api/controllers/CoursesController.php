<?php

namespace app\modules\api\controllers;

use app\models\Course;
use yii\web\Controller;

class CoursesController extends Controller
{
    public function actionAll()
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $departments = Course::all();
        $response->statusCode = 200;

        return $departments;
    }

    public function actionOne($id)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $department = Course::find($id);
        $response->statusCode = 200;

        return 
            $department
        ;
    }

    public function actionPlan($id)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $department = Course::findByPlan($id);
        $response->statusCode = 200;

        return 
            $department
        ;
    }
}
