<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ContestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'init_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'enrollment_date_end') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'remuneration_type_id') ?>

    <?php // echo $form->field($model, 'working_day_type_id') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'category_type_id') ?>

    <?php // echo $form->field($model, 'area_id') ?>

    <?php // echo $form->field($model, 'orientation_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backoffice', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
