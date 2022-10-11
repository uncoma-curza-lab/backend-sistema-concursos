<?php

use app\widgets\notifications\NotificationsGrid;
use yii\helpers\Html;

$this->title = Yii::t('app', 'notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="p-2">

    <?= Html::a('<i class="bi bi-envelope-open"></i> Marcar todas como leídas', ['all-read'], ['class' => 'btn btn-info']) ?>
</div>
<div class="p-2">
    <?= NotificationsGrid::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'message',
            'timestamp',
        ],
    ]); ?>

</div>

</div>

