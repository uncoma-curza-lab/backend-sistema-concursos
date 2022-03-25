<?php

namespace app\controllers;

use app\models\Contests;
use app\models\InscriptionForm;
use app\models\search\MyPostulationsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['contest-inscription'],
                        'roles' => ['postulateToContest'],
                        'roleParams' => function() {
                            return [
                                'contestSlug' => Yii::$app->request->get('slug'),
                            ];
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['my-postulations'],
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return \Yii::$app->user->identity->isValid();
                        }
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if (!\Yii::$app->user->identity->isValid()) {
                        \Yii::$app->cache->set('error', [
                            'message' => 'Debe completar los datos del perfil antes de inscribirse',
                        ]);

                        return $this->redirect([
                            'user/profile',
                        ]);
                    }
                    throw new \yii\web\ForbiddenHttpException('No tiene permisos');

                },
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

        $contest = Contests::find()->onlyPublic()
                                   ->getBySlug($slug);

        $person = \Yii::$app->user->identity->person;

        if ($person->isPostulatedInContest($contest->id)) {
            $this->redirect(Url::toRoute('postulations/my-postulations'));
        }

        $inscriptionForm = new InscriptionForm();
        $inscriptionForm->contest = $contest;

        if ($inscriptionForm->load(Yii::$app->request->post())) {
            if ($inscriptionForm->save()) {
                $this->redirect(Url::toRoute('postulations/my-postulations'));
            }
        }

        return $this->renderAjax('/postulations/inscription', [
            'contest' => $contest,
            'inscriptionForm' => $inscriptionForm,
        ]);
    }

    public function actionMyPostulations()
    {
        $searchModel = new MyPostulationsSearch();
        $dataProvider = $searchModel->search(array_merge(
            [
                'person_id' => Yii::$app->user->identity->person->id
            ],
            $this->request->queryParams
        ));

        return $this->render('my_postulations', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
