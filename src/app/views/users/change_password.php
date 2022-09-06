<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="change-password-form">
    <?php 
      Yii::$app->session->getAllFlashes();
    ?>

    <h1><?= Yii::t('app', 'change_password_title') ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oldPassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
