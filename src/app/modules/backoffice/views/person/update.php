<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Persons */

$this->title = Yii::t('backoffice', 'Update Persons: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Persons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="persons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
