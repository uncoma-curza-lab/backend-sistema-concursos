<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

    <?= $form->field($person, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'dni')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'date_of_birth')->textInput(['maxlength' => true,  'type' => 'date']) ?>

    <div class="form-group accordion" id="addresses-ac">
        <div class="card">
            <div class="card-header" id="placeBirthHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#placeBirthAccordion" aria-expanded="true" aria-controls="placeBirthAccordion">
                        Place of Birth 
                    </button>
                </h2>
            </div>
            <div id="placeBirthAccordion" class="collapse show" aria-labelledby="placeBirthHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $person,
                            'countryName' => 'place_birth_country',
                            'provinceName' => 'place_birth_province',
                            'cityName' => 'place_of_birth',
                            'countryList' => $countryList,
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="legalAddressHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#legalAddressAccordion" aria-expanded="true" aria-controls="legalAddressAccordion">
                       Legal address 
                    </button>
                </h2>
            </div>
            <div id="legalAddressAccordion" class="collapse" aria-labelledby="legalAddressHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $person,
                            'countryName' => 'legal_address_country',
                            'provinceName' => 'legal_address_province',
                            'cityName' => 'legal_address_city_id',
                            'countryList' => $countryList,
                        ]);
                    ?>
                    <?= $form->field($person, 'legal_address_street')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($person, 'legal_address_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="realAddressHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#realAddressAccordion" aria-expanded="true" aria-controls="realAddressAccordion">
                       Legal address 
                    </button>
                </h2>
            </div>
            <div id="realAddressAccordion" class="collapse" aria-labelledby="realAddressHeading" data-parent="#addresses-ac">
                <div class="card-body">
                    <?=
                        $this->render('profile_fragments/_address_form', [
                            'form' => $form,
                            'person' => $person,
                            'countryName' => 'real_address_country',
                            'provinceName' => 'real_address_province',
                            'cityName' => 'real_address_city_id',
                            'countryList' => $countryList,
                        ]);

                    ?>
                    <?= $form->field($person, 'real_address_street')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($person, 'real_address_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
