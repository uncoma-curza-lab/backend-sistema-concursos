<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

  $form = ActiveForm::begin();
?>

  <?= $form->field($modelForm, 'idValid')->dropDownList($modelForm->getValidationStatusList(),[]) ?>
  <?= $form->field($modelForm, 'expireDate', ['options' => ['id' => 'expiredate_field', 'style' => 'display: none;']])->widget(\kartik\datetime\DateTimePicker::class, [
        'class' => 'form-control',
        'type' => \kartik\datetime\DateTimePicker::TYPE_INPUT,
        'options' => ['autocomplete' => 'off'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy HH:ii P',
        ]
    ]) ?>
  <div class="modal-footer">
    <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  </div>
<?php
  ActiveForm::end();

$showDateJs = <<< JS
$('#personalfilevalidationform-idvalid').change(() => {
  if($('#personalfilevalidationform-idvalid').val() == 2){
    $('#expiredate_field').show();
  }else{
    $('#expiredate_field').hide();
  }
})
JS;
$this->registerJs($showDateJs, View::POS_LOAD);


?>
