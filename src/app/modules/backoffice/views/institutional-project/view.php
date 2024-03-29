<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProject */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models/institutional-projects', 'Institutional Project'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="institutional-project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(ucfirst(Yii::t('backoffice', 'update')), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(ucfirst(Yii::t('backoffice', 'delete')), ['delete', 'id' => $model->id], [
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
        ],
    ]) ?>

</div>
