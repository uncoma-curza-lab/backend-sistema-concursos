<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row justify-content-center mb-3">
        <?= $form->field($profile, 'dni', ['options' => ['class' => 'col-md-2']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
        <?= $form->field($profile, 'first_name', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
        <?= $form->field($profile, 'last_name', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
    </div>

    <div class="form-row justify-content-center mb-3">
        <?= $form->field($profile, 'contact_email', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true, 'type' => 'email', 'disabled' => true]) ?>
        <?= $form->field($profile, 'cellphone', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
        <?= $form->field($profile, 'phone', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
    </div>

    <div class="form-row justify-content-center mb-3">
        <?= $form->field($profile, 'date_of_birth', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true,  'type' => 'date', 'disabled' => true]) ?>
        <?= $form->field($profile, 'place_of_birth', ['options' => ['class' => 'col-md-9']])->textInput(['value' => $profile->placeOfBirth->getCompleteString(), 'disabled' => true]) ?>
    </div>

    <div class="form-group accordion" id="addresses-ac">
        <div class="card">
            <div class="card-header" id="legalAddressHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#legalAddressAccordion" aria-expanded="true" aria-controls="legalAddressAccordion">
                        <?= \Yii::t('models/profile', 'legal_address_title'); ?>
                    </button>
                </h2>
            </div>
            <div id="legalAddressAccordion" class="collapse" aria-labelledby="legalAddressHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?= $form->field($profile, 'legal_address_city_id')->textInput([
                        'value' => $profile->legalAddressCity->getCompleteString(),
                        'disabled' => true,
                    ]) ?>
                    <?= $form->field($profile, 'legal_address_street')->textInput([
                        'disabled' => true,
                    ]) ?>
                    <?= $form->field($profile, 'legal_address_number')->textInput([
                        'disabled' => true,
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="realAddressHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#realAddressAccordion" aria-expanded="true" aria-controls="realAddressAccordion">
                        <?= \Yii::t('models/profile', 'real_address_title'); ?>
                    </button>
                </h2>
            </div>
            <div id="realAddressAccordion" class="collapse" aria-labelledby="realAddressHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?= $form->field($profile, 'real_address_city_id')->textInput([
                        'value' => $profile->realAddressCity->getCompleteString(),
                        'disabled' => true,
                    ]) ?>
                    <?= $form->field($profile, 'real_address_street')->textInput([
                        'disabled' => true,
                    ]) ?>
                    <?= $form->field($profile, 'real_address_number')->textInput([
                        'disabled' => true,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
