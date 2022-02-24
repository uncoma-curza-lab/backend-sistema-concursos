<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

use kartik\depdrop\DepDrop;

use dosamigos\tinymce\TinyMce;

$apiUrls = <<< 'JS'
    const $careerBaseUrl = "https://apps.curza.uncoma.edu.ar/api/v1/carrera/departamento?id=";
    let deptoId = '';
    let coursesUrl = '';
JS;

$formatJs = <<< 'JS'
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.nombre 
    }
    var markup = repo.nombre
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.nombre;
}
JS;
 
// Register the formatting script
$this->registerJs($formatJs, View::POS_HEAD);
$this->registerJs($apiUrls, View::POS_HEAD);

$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data,
        //pagination: {
        //    more: (params.page * 30) < data.total_count
        //}
    };
}
JS;
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
        'options' => ['autocomplete' => 'off'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control col-md-6',
        'options' => ['autocomplete' => 'off'],
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>

    <?= $form->field($model, 'enrollment_date_end')->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control col-md-6',
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'options' => ['autocomplete' => 'off'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>
<!--
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
-->
    

    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'es',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'remuneration_type_id')->dropDownList($remunerationTypeList, []) ?>

    <?= $form->field($model, 'working_day_type_id')->dropDownList($workingDayTypeList, []) ?>

    <?= $form->field($model, 'departament_id')->widget(Select2::class, [
        //'data' => $departamentList,
        'initValueText' => $departamentList[$model->departament_id] ?? null,
        'options' => ['placeholder' => 'Seleccione un departamento...'],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => 'https://apps.curza.uncoma.edu.ar/api/v1/departamento',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
                'processResults' => new JsExpression($resultsJs),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('formatRepo'),
            'templateSelection' => new JsExpression('function(depto) {deptoId = depto.id; return depto.nombre || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
        'pluginEvents' => [
            'change' => new JsExpression('function(event){ console.log($("#contests-career_id"));$("#contests-career_id").val("").trigger("change"); deptoId = $(this).val();}'),
        ]
    ]) ?>



    <?= $form->field($model, 'career_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Seleccione una carrera...'],
        'initValueText' => $careerList[$model->career_id] ?? null,
        'pluginOptions' => [
            'allowClear' => true,
            //'minimumInputLength' => 2,
           'ajax' => [
               'url' => new JsExpression('function($ex) {return ($careerBaseUrl + deptoId);}'),
               'dataType' => 'json',
               'delay' => 400,
               'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
               'processResults' => new JsExpression($resultsJs),
           ],
           'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
           'templateResult' => new JsExpression('formatRepo'),
           'templateSelection' => new JsExpression('function(depto) { if (depto.plan_vigente) {coursesUrl = depto.plan_vigente._links.asignaturas.href;} return depto.nombre || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
        'pluginEvents' => [
            'change' => new JsExpression('function(event){ $("#contests-course_id").val("").trigger("change");}'),
        ]
    ]) ?>

    <?= Html::hiddenInput('current_plan_id', 'Plan', ['id' => 'current_plan_id']);?>

    <?= $form->field($model, 'course_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Seleccione una asignatura...'],
        'initValueText' => $courseList[$model->course_id] ?? null,
        'pluginOptions' => [
            'allowClear' => true,
           'ajax' => [
               'url' => new JsExpression('function($ex) {return coursesUrl.replace(/^http:\/\//i, "https://");}'),
               'dataType' => 'json',
               'delay' => 750,
               'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
               'processResults' => new JsExpression($resultsJs),
           ],
           'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
           'templateResult' => new JsExpression('formatRepo'),
           'templateSelection' => new JsExpression('function(depto) {return depto.nombre || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
    ]) ?>

    <?= $form->field($model, 'category_type_id')->dropDownList($categoryTypeList, []) ?>

    <?= $form->field($model, 'area_id')->dropDownList($areaList, [])  ?>

    <?= $form->field($model, 'orientation_id')->dropDownList($orientationList, [])  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
