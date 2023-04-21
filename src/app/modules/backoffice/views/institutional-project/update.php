<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProject */

$this->title = 'Update Institutional Project: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Institutional Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institutional-project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
