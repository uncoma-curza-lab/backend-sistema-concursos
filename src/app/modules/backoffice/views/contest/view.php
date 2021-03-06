<?php

use app\models\ContestStatus;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'Actualizar'), ['update', 'slug' => $model->code], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backoffice', 'Eliminar'), ['delete', 'slug' => $model->code], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backoffice', 'Está seguro de que desea eliminar el concurso?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->contestStatus->is(ContestStatus::DRAFT)) : ?>
        <?= Html::a(Yii::t('backoffice', 'Publicar concurso'), ['publish-contest', 'slug' => $model->code], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('backoffice', 'Está seguro de que desea publciar el concurso?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'code',
            [
                'attribute' => 'course_id',
                'value' => $model->getCourseName(),
            ],
            [
              'attribute' => 'contest_status_id',
              'value' => $model->contestStatus ?  ContestStatus::getTranslation($model->contestStatus->code) : '',
            ],
            'qty',
            [
                'attribute' => 'init_date',
                'type' => 'date',
            ],
            [
                'attribute' => 'end_date',
                'type' => 'date',
            ],
            [
                'attribute' => 'enrollment_date_end',
                'type' => 'date',
            ],
            [
                'attribute' => 'remuneration_type_id',
                'value' => $model->remunerationType->name
            ],
            [
                'attribute' => 'working_day_type_id',
                'value' => $model->workingDayType->name
            ],
            [
                'attribute' => 'category_type_id',
                'value' => $model->categoryType->name
            ],
            [
                'attribute' => 'area_id',
                'value' => $model->getAreaName()
            ],
            [
                'attribute' => 'orientation_id',
                'value' => $model->getOrientationName()
            ],
        ],
    ]) ?>

</div>
