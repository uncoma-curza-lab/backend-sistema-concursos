<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permission */

$this->title = Yii::t('backoffice', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
