<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Areas */

$this->title = Yii::t('backoffice', 'Update city: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="cities-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countryList' => $countryList,
    ]) ?>

</div>
