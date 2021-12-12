<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = Yii::t('backoffice', 'update_contest_title', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backoffice', 'update');
?>
<div class="contests-update">

    <h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', array_merge([
        'model' => $model,
    ], $relationships)) ?>

</div>
