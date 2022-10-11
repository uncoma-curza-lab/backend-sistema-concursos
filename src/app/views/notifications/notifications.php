<?php

use app\widgets\notifications\NotificationsGrid;
use yii\helpers\Html;

$this->title = Yii::t('app', 'notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= NotificationsGrid::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'message',
            'timestamp',
        ],
    ]); ?>

</div>

