<?php

namespace app\controllers;

use app\models\City;
use app\models\Contests;
use app\models\ContestsQuery;
use app\models\Provinces;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LocationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionProvinces()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = [];

        if ($dep = $_POST['depdrop_parents']) {
            $country = $dep[0];
            $provinces = Provinces::find()->where(['=', 'country_id', $country])->all();
            $response = ['output' => ArrayHelper::map($provinces, 'id', fn($model) => $model), 'selected' => ''];
        }
        return $response;
    }

    public function actionCities()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = [];

        if ($dep = $_POST['depdrop_parents']) {
            $province = $dep[0];
            $cities = City::find()->where(['=', 'province_id', $province])->all();
            $response = ['output' => ArrayHelper::map($cities, 'id', fn($model) => $model), 'selected' => ''];
        }
        return $response;
    }
}

