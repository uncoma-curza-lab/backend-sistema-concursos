<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryTypes */

$this->title = Yii::t('backoffice', 'Create Category Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Category Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
