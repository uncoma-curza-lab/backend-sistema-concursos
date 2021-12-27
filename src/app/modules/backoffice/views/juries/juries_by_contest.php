<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backoffice', 'juries_by_contest_title') . ' ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contest') . ' ' . $contest->name, 'url' => [ 'contest/view/'. $contest->code]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="juries-by-contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'add_jury_to_contest_button'), ['add-jury', 'slug' => $contest->code], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'personFullName',
                'label' => 'Nombre y Apellido',
                'value'  =>'user.person.fullname'
            ],
            [
                'attribute' => 'personEmail',
                'label' => 'Email',
                'value'  =>'user.person.contact_email'
            ],
            [
                'attribute' => 'is_president',
                'label' => 'Presidente',
                'value' => fn($value) => $value->is_president ? 'Si' :'No',
            ],
        ],
    ]); ?>


</div>
