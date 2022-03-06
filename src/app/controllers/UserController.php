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
        $person = \Yii::$app->user->identity->person ?? new Persons();
        $profileForm = new ProfileForm();
        $request = \Yii::$app->request;

        if ($request->isPost && $person->load($request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $user = \Yii::$app->user->identity;
                if (!$user->active) {
                    $user->active = true;
                    $user->save();
                }
                $person->user_id = $user->id;
                if (!$person->is_valid) {
                    $person->is_valid = true;
                }
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
            'person' => $profileForm,
            'error' => $error,
            'countryList' => ArrayHelper::map(Countries::find()->all(), 'id', 'name'),
        ]);
    }

}
