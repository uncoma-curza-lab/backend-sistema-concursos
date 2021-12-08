<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RemunerationType */

$this->title = Yii::t('backoffice', 'Create Remuneration Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Remuneration Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remuneration-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
