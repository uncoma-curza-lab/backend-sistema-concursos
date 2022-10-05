<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'message',
            'timestamp',
        ],
    ]); ?>

</div>

