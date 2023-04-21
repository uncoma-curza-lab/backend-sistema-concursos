<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProject */

$this->title = 'Create Institutional Project';
$this->params['breadcrumbs'][] = ['label' => 'Institutional Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institutional-project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
