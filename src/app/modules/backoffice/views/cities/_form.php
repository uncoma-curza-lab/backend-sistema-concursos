<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Areas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'name' => 'country_id',
        'data' => $countryList,
        'value' => $model->province->country_id ?? null,
        'options' => [
            'placeholder' => 'Seleccione País...',
            'id' => 'country',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'province_id')->widget(DepDrop::class, [
        'options' => ['placeholder' => 'Seleccione la provincia de referencia...'],
        'value' => $model->province_id,
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'data' => $model->province_id ? [$model->province_id => $model->province->name] : null,
        'pluginOptions' => [
            'allowClear' => true,
            'depends' => [ 'country' ],
            'initialize' => true,
            'url' => Url::to(['/backoffice/provinces/country'])
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
