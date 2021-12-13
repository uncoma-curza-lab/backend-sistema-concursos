<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backoffice', 'postulations_by_contest_title') . ' ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contest') . ' ' . $contest->name, 'url' => [ 'contest/view/'. $contest->code]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postulations-by-contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'personFullName',
                'label' => 'Nombre y Apellido',
                'value'  =>'person.fullName'
            ],
            [
                'attribute' => 'personEmail',
                'label' => 'Email',
                'value'  =>'person.email'
            ],
        ],
    ]); ?>


</div>