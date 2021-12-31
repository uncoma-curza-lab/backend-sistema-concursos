<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<div class="contests-form">

<?php

$form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qty')->textInput([
        'class' => 'form-control col-md-3',
        'type' => 'number',
    ]) ?>

    <?= $form->field($model, 'init_date')->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control col-md-6',
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control col-md-6',
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>

    <?= $form->field($model, 'enrollment_date_end')->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control col-md-6',
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'remuneration_type_id')->dropDownList($remunerationTypeList, []) ?>

    <?= $form->field($model, 'working_day_type_id')->dropDownList($workingDayTypeList, []) ?>

    <?= $form->field($model, 'course_id')->widget(Select2::class, [
        'data' => $courseList,
    ]) ?>

    <?= $form->field($model, 'category_type_id')->dropDownList($categoryTypeList, []) ?>

    <?= $form->field($model, 'area_id')->dropDownList($areaList, [])  ?>

    <?= $form->field($model, 'orientation_id')->dropDownList($orientationList, [])  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
