<?php

namespace app\modules\backoffice\controllers;

use app\models\Contests;
use app\models\PersonalFile;
use app\models\Persons;
use app\models\Postulations;
use app\models\PostulationStatus;
use app\modules\backoffice\searchs\PostulationsByContestSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'approve' => ['POST'],
                        'reject' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['viewImplicatedPostulations'],
                            'actions' => ['contest'],
                            'roleParams' => function() {
                                return [
                                    'contestSlug' => Yii::$app->request->get('slug'),
                                ];
                            },
                        ],
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin'],
                            'actions' => ['approve', 'contest', 'reject', 'show'],
                        ],
                    ]
                ],
            ],
        );
    }

    public function actionContest($slug)
    {
        $contest = $this->findContest($slug);
        $searchModel = new PostulationsByContestSearch($slug);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/contest/contest_details', [
            'view' => '/postulation/_postulations_by_contest',
            'params' => [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'contest' => $contest,
                'model' => $contest
            ],
        ]);
    }

    public function actionApprove($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $postulation->status = PostulationStatus::ACCEPTED;
        $postulation->save();
        return $this->redirect(['contest', 'slug' => $postulation->contest->code]);
    }

    public function actionReject($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $postulation->status = PostulationStatus::REJECTED;
        $postulation->save();
        return $this->redirect(['contest', 'slug' => $postulation->contest->code]);
    }

    public function actionShow($postulationId)
    {
        $postulation = Postulations::findOne($postulationId);
        $person = $postulation->person;
        $files = PersonalFile::find()->postulation_files($postulationId)->all();
        return $this->render('show', [
            'profile' => $person,
            'postulation' => $postulation,
            'files' => $files,
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
