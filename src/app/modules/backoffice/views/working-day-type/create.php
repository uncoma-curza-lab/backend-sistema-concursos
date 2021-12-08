<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkingDayTypes */

$this->title = Yii::t('backoffice', 'Create Working Day Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Working Day Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-day-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
