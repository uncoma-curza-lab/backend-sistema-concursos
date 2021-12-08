<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkingDayTypes */

$this->title = Yii::t('backoffice', 'Update Working Day Types: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Working Day Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="working-day-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
