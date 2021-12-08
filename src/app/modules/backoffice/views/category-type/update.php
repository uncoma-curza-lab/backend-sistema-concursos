<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryTypes */

$this->title = Yii::t('backoffice', 'Update Category Types: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Category Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'Update');
?>
<div class="category-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
