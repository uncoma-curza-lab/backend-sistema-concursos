<?php

namespace app\controllers;

use app\models\ContestAttachedFile;
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
    public function actionList($slug = 'all')
    {

        $buildQuery = Contests::find()->with([ 'workingDayType', 'juries' ]);

        switch ($slug) {
            case 'future':
                $buildQuery->onlyPublic()
                           ->initiated(false)
                           ->finished(false);
                break;
             case 'active':
                 $buildQuery->onlyPublic()
                            ->initiated()
                            ->finished(false);
                break;
           
            default:
                $buildQuery->onlyPublic();
                break;
        }

        $buildQuery->sortBy(['init_date' => SORT_DESC, 'id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $buildQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('/contests/public_list', [
            'dataProvider' => $dataProvider,
            'type' => $slug
        ]);
    }

    public function actionDetails($slug)
    {
        $contest = $this->findModel($slug);
        $attachedFiles = ContestAttachedFile::find()->inSameContest($contest->id)->onlyPublished()->all();

        return $this->render('/contests/details', [
            'contest' => $contest,
            'attachedFiles' => $attachedFiles,
        ]);    
    }

    protected function findModel($slug)
    {
        if (($model = Contests::find()->filterBySlug($slug)->complete()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }
}
