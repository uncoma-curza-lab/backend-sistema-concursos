<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backoffice', 'Areas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'Create Areas'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'contest.name',
            [
                'attribute' => 'contest.init_date'
            ],
            [
                'attribute' => 'contest.enrollment_date_end',
            ],
            [
                'attribute' => 'status_description',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>


</div>
