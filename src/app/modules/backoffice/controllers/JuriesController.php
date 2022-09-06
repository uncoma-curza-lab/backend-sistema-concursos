<?php

namespace app\modules\backoffice\controllers;

use app\models\ContestJury;
use app\models\Contests;
use app\models\User;
use app\modules\backoffice\models\AddJuryForm;
use app\modules\backoffice\searchs\JuriesByContestSearch;
use Yii;
use yii\filters\AccessControl;
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
                            'actions' => ['add-jury', 'delete', 'contest'],
                        ],
                    ]
                ],
            ],
        );
    }

    public function actionContest($slug)
    {

        //\Yii::$app->user->identity->isPresident($slug);
        $contest = $this->findContest($slug);
        $searchModel = new JuriesByContestSearch($slug);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/contest/contest_details', [
            'view' => '/juries/_juries_by_contest',
            'params' => [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
                 'contest' => $contest,
                 'model' => $contest
            ],
        ]);
    }

    public function actionAddJury($slug)
    {
        $contest = $this->findContest($slug);
        $juryForm = new AddJuryForm();

        if ($this->request->isPost && $juryForm->load($this->request->post())) {
            $juryForm->saveJury($contest->id);
            return $this->redirect(['contest', 'slug' => $contest->code]);
        }

        $juryUsers = [];
        $users = User::find()->all(); 
        array_walk($users, function($user) use (&$juryUsers) {
            $juryUsers[ $user->id ] = $user->person->first_name . ' ' . $user->person->last_name;
        });

        return $this->render('add_jury', [
            'model' => $juryForm,
            'contest' => $contest,
            'juryUsers' => $juryUsers
        ]);
    }

    public function actionDelete($user, $contest)
    {
        $jury = ContestJury::find()->getByContestAndUser($user, $contest);
        $contest = $jury->contest;
        $jury->delete();
        return $this->redirect(['contest', 'slug' => $contest->code]);
    }

    protected function findContest($slug)
    {
        if (($model = Contests::find()->findBySlug($slug)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }
}
