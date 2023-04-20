<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProyect */

$this->title = 'Create Institutional Proyect';
$this->params['breadcrumbs'][] = ['label' => 'Institutional Proyects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institutional-proyect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
