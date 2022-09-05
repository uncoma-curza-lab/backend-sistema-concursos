<?php

namespace app\controllers;

use app\models\City;
use app\models\Countries;
use app\models\Persons;
use app\models\ProfileForm;
use app\models\ChangePasswordForm;
use app\models\Provinces;
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
                        'actions' => ['logout', 'profile', 'change-password'],
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
        if ($request->isPost) {
          if ($profileForm->load($request->post()) && $profileForm->save()) {
            \Yii::$app->session->setFlash('success', 'Su información fue guardada con éxito');
            return $this->refresh();
          }
          \Yii::$app->session->setFlash('error', 'No se pudo guardar su información');
        }
        $countries = Countries::find()->where(['=', 'code', 'AR'])->all();
        $provinces = Provinces::find()->all();
        $cities = City::find()->all();
        return $this->render('/users/profile', [
            'person' => $profileForm,
            'error' => $error,
            'countryList' => ArrayHelper::map($countries, 'id', 'name'),
            'provincesList' => ArrayHelper::map($provinces, 'id', 'name'),
            'citiesList' => ArrayHelper::map($cities, 'id', 'name'),
        ]);
    }

    public function actionChangePassword()
    {
        $changePasswordForm = new ChangePasswordForm();

        $request = \Yii::$app->request;
        if ($request->isPost) {
          if ($changePasswordForm->load($request->post()) && $changePasswordForm->changePassword()) {
            \Yii::$app->session->setFlash('success', 'Su contraseña fue actualizada con éxito');
            return $this->refresh();
          }
          \Yii::$app->session->setFlash('error', 'No se pudo guardar la contraseña. Verifique la información');
        }

        return $this->render('/users/change_password', [
            'model' => $changePasswordForm,
        ]);

    }
}
