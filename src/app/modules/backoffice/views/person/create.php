<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Persons */

$this->title = Yii::t('backoffice', 'Create Persons');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Persons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
