<?php

namespace app\modules\backoffice\controllers;

use app\models\Contests;
use app\modules\backoffice\searchs\PostulationsByContestSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

class PostulationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionContest($slug)
    {
        $contest = $this->findContest($slug);
        $searchModel = new PostulationsByContestSearch($slug);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('postulations_by_contest', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contest' => $contest
        ]);
    }

    public function actionTest()
    {
        var_dump(\Yii::$app->user->can('postulateToContest'));
        die();
    }

    private function findContest(string $slug)
    {
        return Contests::find()->findBySlug($slug);
    }
}
