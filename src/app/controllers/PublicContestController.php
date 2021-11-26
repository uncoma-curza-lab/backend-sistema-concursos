<?php

namespace app\controllers;

use app\models\Contests;
use app\models\ContestsQuery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

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

        //TODO: with remuneration type.
        $buildQuery = Contests::find()->with('workingDayType')
                                       ->onlyPublic()
                                       ->sortBy(['init_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $buildQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('/site/contests/public_list', [
            'dataProvider' =>$dataProvider
        ]);
    }
}
