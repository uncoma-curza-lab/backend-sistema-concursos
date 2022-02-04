<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContestStatus */

$this->title = Yii::t('backoffice', 'Create Contest Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contest Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contest-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
