<?php

use yii\helpers\Html;

$this->title = Yii::t('backoffice', 'Create Province');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Province'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provinces-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'refModel' => $refModel,
    ]) ?>

</div>
