<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'postulations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-postulations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contest.name',
            [
                'attribute' => 'contest.init_date'
            ],
            [
                'attribute' => 'contest.enrollment_date_end',
            ],
            [
                'attribute' => 'status',
                'value' => fn($model) => $model->getStatusDescription()
            ],
            'created_at:datetime',
            //[
            //    'class' => 'yii\grid\ActionColumn',
            //],
        ],
    ]); ?>


</div>
