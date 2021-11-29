<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backoffice', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backoffice', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'qty',
            'init_date',
            'end_date',
            'enrollment_date_end',
            'description:ntext',
            'remuneration_type_id',
            'working_day_type_id',
            'course_id',
            'category_type_id',
            'area_id',
            'orientation_id',
        ],
    ]) ?>

</div>
