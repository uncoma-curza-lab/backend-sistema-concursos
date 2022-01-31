<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = Yii::t('backoffice', 'Update Users: {name}', [
    'name' => $model->uid,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid];//, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
