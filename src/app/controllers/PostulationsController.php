<?php

namespace app\controllers;

use app\models\Contests;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostulationsController extends Controller
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
    public function actionContestInscription($slug)
    {

        var_dump('qwe');
        die();
        $contest = Contests::find()->getBySlug($slug);

        return $this->render('/postulations/inscription', [
            'contest' => $contest
        ]);
    }
}
