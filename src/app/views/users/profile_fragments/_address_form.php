<?php
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
?>

<?= $form->field($person, $countryName)->widget(Select2::class, [
    'data' => $countryList,
    'options' => [
        'placeholder' => 'Seleccione un país...',
        'id' => $countryName . '-id',
    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($person, $provinceName)->widget(DepDrop::class, [
    'data' => $person->$provinceName ? $provincesList : null,
    'type' => DepDrop::TYPE_SELECT2,
    'options' => [
        'id' => $provinceName . '-id',
    ],
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'placeholder' => 'Seleccione una provincia...',
        'depends' => [
            $countryName . '-id',
        ],
        'url' => Url::to(['location/provinces']),
        'loadingText' => 'Aguarde un momento...',
    ],
]) ?>

<?= $form->field($person, $cityName)->widget(DepDrop::class, [
    'data' => $person->$cityName ? $citiesList : null,
    'type' => DepDrop::TYPE_SELECT2,
    'options' => [
        'id' => $cityName . '-id',
    ],
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'placeholder' => 'Seleccione una ciudad/localidad/municipio...',
        'depends' => [
            $countryName . '-id',
            $provinceName . '-id',
        ],
        'allowClear' => true,
        'url' => Url::to(['location/cities']),
        'loadingText' => 'Aguarde un momento...',
    ],
]) ?>
