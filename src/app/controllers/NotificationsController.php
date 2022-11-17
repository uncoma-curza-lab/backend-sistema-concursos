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
                        'actions' => ['index', 'all-read', 'read'],
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

        $pagination = $_GET && isset($_GET['pagination']) ? $_GET['pagination'] : 25;
        $dataProvider->setPagination(['pageSize' => $pagination]);

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

    public function actionRead(int $notificationId)
    {
        $notification = Notification::findOne($notificationId);

        $notification->changeReadStatus();
        return $this->redirect(['index']);
    }

}
