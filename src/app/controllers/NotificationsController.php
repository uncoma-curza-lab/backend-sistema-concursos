<?php

namespace app\controllers;

use app\models\Notification;
use app\models\search\MyNotificationsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class NotificationsController extends Controller
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
                        'actions' => ['index', 'all-read'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new MyNotificationsSearch();
        $dataProvider = $searchModel->search(array_merge(
            [
                'user_to' => Yii::$app->user->id
            ],
            $this->request->queryParams
        ));

        return $this->render('notifications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAllRead()
    {
        Notification::markAllAsRead();

       return $this->redirect(['index']);
    }
}
