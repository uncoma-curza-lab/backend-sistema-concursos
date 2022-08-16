<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Contests;
use app\models\Query;
use app\models\SignupForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class RegisterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'signup' => ['get','post'],
                ],
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    \Yii::$app->cache->set('error', [
                        'message' => 'Debe completar los datos del perfil antes de inscribirse',
                    ]);
                    return $this->redirect([
                        'user/profile',
                    ]);
                }
            }
        }

        return $this->render('/site/signup', [
            'model' => $model,
        ]);
    }


}
