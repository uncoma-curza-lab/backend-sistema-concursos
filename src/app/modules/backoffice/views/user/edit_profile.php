<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($profile, 'first_name')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'last_name')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'contact_email')->textInput(['maxlength' => true, 'type' => 'email', 'disabled' => true]) ?>


    <?= $form->field($profile, 'cellphone')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'phone')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'dni')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'date_of_birth')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($profile, 'is_valid')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
