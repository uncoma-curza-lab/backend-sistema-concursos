<?php

namespace app\controllers;

use app\models\Contests;
use app\models\ContestsQuery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PublicContestController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $buildQuery = Contests::find()->with('workingDayType')
                                       ->onlyPublic()
                                       ->sortBy(['init_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $buildQuery,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        return $this->render('/contests/public_list', [
            'dataProvider' =>$dataProvider
        ]);
    }

    public function actionDetails($slug)
    {
        $data = $this->findModel($slug);
        $dataSerializada = [];

        $dataSerializada['area'] = $data->getArea()->one()->name;
        $dataSerializada['orientation'] = $data->getOrientation()->one()->name;          
        $dataSerializada['categoryType'] = $data->getCategoryType()->one()->name;
        $dataSerializada['workingDayType'] = $data->getWorkingDayType()->one()->name;     

        return $this->render('/contests/details', [
            'data' => $data,
            'dataSerializada' => $dataSerializada,
        ]);    

              
    }

    protected function findModel($slug)
    {
        if (($model = Contests::find()->findBySlug($slug)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }
}
