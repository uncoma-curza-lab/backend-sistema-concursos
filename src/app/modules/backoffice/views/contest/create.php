<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = Yii::t('backoffice', 'create_contest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', array_merge([
        'model' => $model,
    ], $relationships)) ?>

</div>
