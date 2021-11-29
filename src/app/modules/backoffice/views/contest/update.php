<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = Yii::t('backoffice', 'Update Contests: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="contests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
