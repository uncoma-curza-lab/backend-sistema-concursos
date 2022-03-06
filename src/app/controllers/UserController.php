<?php

namespace app\controllers;

use app\models\Countries;
use app\models\Persons;
use app\models\ProfileForm;
use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'profile'],
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
    public function actionProfile()
    {

        $error = \Yii::$app->cache->get('error');
        if ($error) {
            \Yii::$app->cache->delete('error');
        }

        $person = \Yii::$app->user->identity->person ?? null;
        $profileForm = new ProfileForm();
        if ($person) {
            $profileForm->populate($person);
        }

        $request = \Yii::$app->request;
        if ($request->isPost && $profileForm->load($request->post()) && $profileForm->save()) {
            \Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('/users/profile', [
            'person' => $profileForm,
            'error' => $error,
            'countryList' => ArrayHelper::map(Countries::find()->all(), 'id', 'name'),
        ]);
    }

}
