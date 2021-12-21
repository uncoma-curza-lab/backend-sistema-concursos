<?php

namespace app\modules\backoffice\controllers;

use app\models\Contests;
use app\modules\backoffice\searchs\JuriesByContestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContestController implements the CRUD actions for Contests model.
 */
class JuriesController extends Controller
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
        $searchModel = new JuriesByContestSearch($slug);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('juries_by_contest', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contest' => $contest
        ]);
    }

    protected function findContest($slug)
    {
        if (($model = Contests::find()->findBySlug($slug)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }
}
