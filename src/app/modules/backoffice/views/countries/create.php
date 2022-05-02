<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Areas */

$this->title = Yii::t('backoffice', 'Create Country');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Country'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
