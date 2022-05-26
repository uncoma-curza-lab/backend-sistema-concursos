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

    <?= $form->field($profile, 'date_of_birth')->textInput(['maxlength' => true,  'type' => 'date', 'disabled' => true]) ?>

    <div class="form-group accordion" id="addresses-ac">
        <div class="card">
            <div class="card-header" id="placeBirthHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#placeBirthAccordion" aria-expanded="true" aria-controls="placeBirthAccordion">
                        <?= \Yii::t('models/profile', 'place_of_birth_title'); ?>
                    </button>
                </h2>
            </div>
            <div id="placeBirthAccordion" class="collapse" aria-labelledby="placeBirthHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $profile,
                            'countryName' => 'place_birth_country',
                            'provinceName' => 'place_birth_province',
                            'cityName' => 'place_of_birth',
                            'countryList' => [],
                            'provincesList' => [],
                            'citiesList' => [],
                        ]);
                    ?>
                </div>
            </div>
        </div>
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
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $profile,
                            'countryName' => 'legal_address_country',
                            'provinceName' => 'legal_address_province',
                            'cityName' => 'legal_address_city_id',
                            'provincesList' => [],
                            'citiesList' => [],
                            'countryList' => [],
                        ]);
                    ?>
                    <?= $form->field($profile, 'legal_address_street')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($profile, 'legal_address_number')->textInput(['maxlength' => true]) ?>
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
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $profile,
                            'countryName' => 'real_address_country',
                            'provinceName' => 'real_address_province',
                            'cityName' => 'real_address_city_id',
                            'countryList' => [],
                            'provincesList' => [],
                            'citiesList' => [],
                        ]);

                    ?>
                    <?= $form->field($profile, 'real_address_street')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($profile, 'real_address_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
