<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div id='alert'>
</div>
<div class="inscription-to-contest-form">

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax_inscription_form', 'clientOptions' => ['method' => 'POST' ], 'enablePushState' => 0, 'timeout' => 10000]); ?>
    <?php $form = ActiveForm::begin(['id' => 'inscription-form','options' => [ 'data-pjax' => true ]]); ?>

    <?= $form->field($inscriptionForm, 'accepted_term_article22')->checkbox([
        'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <?= $form->field($inscriptionForm, 'confirm_data')->checkbox([
        'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Confirmar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

     <?php \yii\widgets\Pjax::end(); ?>
</div>
