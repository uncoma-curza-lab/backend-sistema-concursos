<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PersonsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'dni') ?>

    <?php // echo $form->field($model, 'contact_email') ?>

    <?php // echo $form->field($model, 'cellphone') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'real_address') ?>

    <?php // echo $form->field($model, 'legal_address') ?>

    <?php // echo $form->field($model, 'citizenship') ?>

    <?php // echo $form->field($model, 'date_of_birth') ?>

    <?php // echo $form->field($model, 'place_of_birth') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backoffice', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
