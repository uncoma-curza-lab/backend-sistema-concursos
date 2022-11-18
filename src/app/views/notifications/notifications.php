<?php

use app\widgets\notifications\NotificationsGrid;
use yii\helpers\Html;

$this->title = Yii::t('app', 'notifications');
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= NotificationsGrid::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'markAllAsRead' => true,
            'selectPaginationSize' => true,
        ],
        'columns' => [
            'message',
            'timestamp',
            'actions'
        ],
    ]); ?>

</div>

