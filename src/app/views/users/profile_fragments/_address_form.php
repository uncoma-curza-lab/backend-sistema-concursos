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
    'data' => $provincesList,
    'type' => DepDrop::TYPE_SELECT2,
    'value' => $person->$provinceName ??  null,
    'options' => [
        'id' => $provinceName . '-id',
    ],
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'placeholder' => 'Seleccione una provincia...',
        'depends' => [
            $countryName . '-id',
        ],
        'allowClear' => true,
        'url' => Url::to(['location/provinces']),
        'loadingText' => 'Aguarde un momento...',
    ],
]) ?>

<?= $form->field($person, $cityName)->widget(DepDrop::class, [
    'data' => $citiesList,
    'type' => DepDrop::TYPE_SELECT2,
    'value' => $person->$cityName ?? null,
    'options' => [
        'id' => $cityName . '-id',
    ],
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'placeholder' => 'Seleccione una ciudad/localidad/municipio...',
        'depends' => [
            $provinceName . '-id',
        ],
        'allowClear' => true,
        'url' => Url::to(['location/cities']),
        'loadingText' => 'Aguarde un momento...',
    ],
]) ?>
