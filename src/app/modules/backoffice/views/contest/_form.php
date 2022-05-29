<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

use dosamigos\tinymce\TinyMce;

$spcBase = Yii::$app->params['spc']['local'];
$apiUrls = <<< 'JS'
    const $careerBaseUrl = "/careers/departments";
    const $courseBaseUrl = "/courses/plan"
    let deptoId = '';
    let coursesUrl = '';
JS;

$formatJs = <<< 'JS'
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.text
    }
    var markup = repo.text
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.text;
}
JS;

$defineRequireFields = <<<'JS'
const activity = $('#contests-activity');
const categoryType = $('#contests-category_type_id');
const targetFields = {
  course_id: $('#contests-course_id'),
  departament_id: $('#contests-departament_id'),
  career_id: $('#contests-career_id'),
  area_id: $('#contests-area_id'),
  orientation_id: $('#contests-orientation_id'),
};

const fieldsRequired = () => {
  switch(activity.val()) {
    case 'DEPARTMENT_ASSISTANT':
      targetFields.course_id.parent().hide();
      targetFields.departament_id.parent().hide();
      targetFields.career_id.parent().hide();
      targetFields.orientation_id.parent().hide();
      targetFields.area_id.parent().hide();
      break;
    default:
      if(Number(categoryType.val()) === 3) {
        targetFields.course_id.parent().hide();
        targetFields.departament_id.parent().hide();
        targetFields.career_id.parent().hide();
      } else {
        targetFields.course_id.parent().show();
        targetFields.departament_id.parent().show();
        targetFields.career_id.parent().show();
        targetFields.orientation_id.parent().show();
        targetFields.area_id.parent().show();
      }

      break;

  }
}
activity.on('change', () => {
  fieldsRequired();

});

categoryType.on('change', () => {
  fieldsRequired();
});

JS;
 
// Register the formatting script
$this->registerJs($apiUrls, View::POS_HEAD);
$this->registerJs($formatJs, View::POS_HEAD);
$this->registerJs($defineRequireFields, View::POS_LOAD);

$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    mapped = data.map(item => {
        mapItem = {
            id: item.code,
            text: item.name
        }
        if (item.metadata && item.metadata.actually_plan){
            mapItem["plan_id"] = item.metadata.actually_plan.id;
        }
        return mapItem;

    })
    return {
        results: mapped
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

    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
        'options' => ['rows' => 15],
        'language' => 'es',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        ]
    ]);?>
    <?= $form->field($model, 'activity')->dropDownList($activityList, []) ?>

    <?= $form->field($model, 'remuneration_type_id')->dropDownList($remunerationTypeList, []) ?>

    <?= $form->field($model, 'working_day_type_id')->dropDownList($workingDayTypeList, []) ?>

    <?= $form->field($model, 'departament_id')->widget(Select2::class, [
        //'data' => $departamentList,
        'initValueText' => $departamentList[$model->departament_id] ?? null,
        'options' => ['placeholder' => 'Seleccione un departamento...'],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $spcBase . '/departments',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {return {q:params.term, page: params.page}; }'),
                'processResults' => new JsExpression($resultsJs),
            ],
            'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
            'templateResult' => new JsExpression('formatRepo'),
            'templateSelection' => new JsExpression('function(depto) { deptoId = depto.id; return depto.name || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
        'pluginEvents' => [
            'change' => new JsExpression('function(event){ $("#contests-career_id").val("").trigger("change"); deptoId = $(this).val();}'),
        ]
    ]) ?>



    <?= $form->field($model, 'career_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Seleccione una carrera...'],
        'initValueText' => $careerList[$model->career_id] ?? null,
        'pluginOptions' => [
            'allowClear' => true,
           'ajax' => [
               'url' => new JsExpression('function($ex) {return ("' . $spcBase .'" + $careerBaseUrl + "/" + deptoId);}'),
               'dataType' => 'json',
               'delay' => 400,
               'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
               'processResults' => new JsExpression($resultsJs),
           ],
           'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
           'templateResult' => new JsExpression('formatRepo'),
           'templateSelection' => new JsExpression('function(depto) { if (depto.plan_id) {coursesUrl = "' . $spcBase . '" + $courseBaseUrl + "/" +depto.plan_id;} return depto.name || depto.text;}')
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
               'url' => new JsExpression('function($ex) {return coursesUrl;}'),
               'dataType' => 'json',
               'delay' => 750,
               'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
               'processResults' => new JsExpression($resultsJs),
           ],
           'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
           'templateResult' => new JsExpression('formatRepo'),
           'templateSelection' => new JsExpression('function(depto) {return depto.name || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
    ]) ?>

    <?= $form->field($model, 'evaluation_departament_id')->widget(Select2::class, [
        'initValueText' => $departamentList[$model->evaluation_departament_id] ?? null,
        'options' => ['placeholder' => 'Seleccione el departamento evaluador...'],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $spcBase . '/departments',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {return{q:params.term, page: params.page}; }'),
                'processResults' => new JsExpression($resultsJs),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('formatRepo'),
            'templateSelection' => new JsExpression('function(depto) {return depto.name || depto.text;}')//new JsExpression('formatRepoSelection'),
        ],
    ]) ?>

    <?= $form->field($model, 'category_type_id')->dropDownList($categoryTypeList, []) ?>

    <?= $form->field($model, 'area_id')->dropDownList($areaList, [])  ?>

    <?= $form->field($model, 'orientation_id')->dropDownList($orientationList, [])  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'save_button'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
