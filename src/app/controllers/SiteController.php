<?php

namespace app\controllers;

use app\controllers\interfaces\SCController;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Contests;
use yii\data\ActiveDataProvider;

class SiteController extends SCController 
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
                                      ->initiated()
                                      ->finished(false)
                                      ->sortBy([
                                          'init_date' => SORT_DESC,
                                      ])
                                      ->limit(8);

        $dataProvider = new ActiveDataProvider([
            'query' => $buildQuery,
            'pagination' => false,
        ]);

        $highlighteds = Contests::find()->with('workingDayType')
                                       ->onlyPublicAndHighlighted()
                                       ->sortBy(['updated_at' => SORT_DESC]);

        $dataProviderHighlighteds = new ActiveDataProvider([
            'query' => $highlighteds,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);


        return $this->render('index', [
            'dataProvider' =>$dataProvider,
            'dataProviderHighlighteds' =>$dataProviderHighlighteds
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionHelp()
    {
        return $this->render('help');
    }
}
