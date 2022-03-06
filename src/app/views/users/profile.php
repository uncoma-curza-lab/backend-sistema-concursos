<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
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

    <?= $form->field($person, 'legal_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'real_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'dni')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'date_of_birth')->textInput(['maxlength' => true]) ?>

    <?= $form->field($person, 'country')->widget(Select2::class, [
        'data' => $countryList,
        'options' => [
            'placeholder' => 'Seleccione un departamento...',
            'id' => 'country-select2'
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($person, 'province')->widget(DepDrop::class, [
        'options' => [
            'id' => 'provinces-id',
        ],
        'pluginOptions' => [
            'placeholder' => 'Seleccione un departamento...',
            'depends' => [
                'country-select2',
            ],
            'allowClear' => true,
            'url' => Url::to(['location/provinces']),
        ],
    ]) ?>

    <?= $form->field($person, 'city')->widget(DepDrop::class, [
        'options' => [
            'id' => 'city-id',
        ],
        'pluginOptions' => [
            'placeholder' => 'Seleccione un departamento...',
            'depends' => [
                'provinces-id',
            ],
            'allowClear' => true,
            'url' => Url::to(['location/cities']),
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
