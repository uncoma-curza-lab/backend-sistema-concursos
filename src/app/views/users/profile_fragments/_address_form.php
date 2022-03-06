<?php
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
?>

<?= $form->field($person, $countryName)->widget(Select2::class, [
    'data' => $countryList,
    'options' => [
        'placeholder' => 'Seleccione un departamento...',
        'id' => $countryName . '-id',
    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($person, $provinceName)->widget(DepDrop::class, [
    'type' => DepDrop::TYPE_SELECT2,
    'options' => [
        'id' => $provinceName . '-id',
    ],
    'pluginOptions' => [
        'placeholder' => 'Seleccione un departamento...',
        'depends' => [
            $countryName . '-id',
        ],
        'allowClear' => true,
        'url' => Url::to(['location/provinces']),
    ],
]) ?>

<?= $form->field($person, $cityName)->widget(DepDrop::class, [
    'type' => DepDrop::TYPE_SELECT2,
    'options' => [
        'id' => $cityName . '-id',
    ],
    'pluginOptions' => [
        'placeholder' => 'Seleccione un departamento...',
        'depends' => [
            $provinceName . '-id',
        ],
        'allowClear' => true,
        'url' => Url::to(['location/cities']),
    ],
]) ?>
