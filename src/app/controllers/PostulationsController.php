<?php

namespace app\controllers;

use app\models\Contests;
use app\models\InscriptionForm;
use app\models\PostulationsQuery;
use app\models\search\PostulationsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['contest-inscription'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['contest-inscription'],
                        'roles' => ['@', 'jury'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionContestInscription($slug)
    {

        $contest = Contests::find()->onlyPublic()
                                   ->getBySlug($slug);

        $inscriptionForm = new InscriptionForm();
        $inscriptionForm->contest = $contest;

        if ($inscriptionForm->load(Yii::$app->request->post())) {
            $inscriptionForm->save();
            $this->redirect(Url::toRoute('postulations/my-postulations'));
        }

        return $this->render('/postulations/inscription', [
            'contest' => $contest,
            'inscriptionForm' => $inscriptionForm,
        ]);
    }

    public function actionMyPostulations()
    {
        $searchModel = new PostulationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('my_postulations', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
