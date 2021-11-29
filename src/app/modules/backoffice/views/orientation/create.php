<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Orientations */

$this->title = Yii::t('backoffice', 'Create Orientations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Orientations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orientations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
