<?php

use yii\helpers\Html;

$this->title = Yii::t('backoffice', 'Create City');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'City'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countryList' => $countryList,
    ]) ?>

</div>
