<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="inscription-to-contest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($inscriptionForm, 'terms_accepted')->checkbox([
        'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Confirmar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
