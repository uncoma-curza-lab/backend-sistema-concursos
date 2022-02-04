<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">
<?php if($error): ?>
<div class="alert alert-warning" role="alert">
<?= $error['message'] ?? 'Ocurrió un error' ?>
</div>
<?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($person, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'contact_email')->textInput(['maxlength' => true, 'type' => 'email']) ?>

    <?= $form->field($person, 'legal_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'real_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'dni')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'date_of_birth')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
