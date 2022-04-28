<?php

namespace app\modules\api\controllers;

use app\models\Departament;
use yii\web\Controller;

class DepartmentsController extends Controller
{
    const $methodResources= [
        'departments' => Departament::class,
    ];

    public function actionAll()
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $departments = Departament::all();
        $response->statusCode = 200;

        return $departments;
    }

    public function actionOne($id)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $department = Departament::find($id);
        $response->statusCode = 200;

        return 
            $department
        ;
    }
}
