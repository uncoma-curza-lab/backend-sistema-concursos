<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RemunerationType */

$this->title = Yii::t('backoffice', 'Update Remuneration Type: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Remuneration Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="remuneration-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
