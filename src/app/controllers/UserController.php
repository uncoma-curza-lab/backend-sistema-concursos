<?php

namespace app\controllers;

use app\models\Persons;
use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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

        $person = \Yii::$app->user->identity->person ?? new Persons();
        $request = \Yii::$app->request;

        if ($request->isPost && $person->load($request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $person->user_id = \Yii::$app->user->identity->id;
                $person->save();

                \Yii::$app->session->setFlash('contactFormSubmitted');
                $transaction->commit();

                return $this->refresh();
            } catch (\Throwable $e) {
                // TODO Log error
            }

            $transaction->rollBack();
        }

        return $this->render('/users/profile', [
            'person' => $person,
        ]);
    }

}
