<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

<div class="container">

<button class="btn btn-warning mb-3" id="showFormBtn" title="Validar" ><i class="bi bi-check2-circle"></i> Validar</button>

  <div id="form" class="card border-info mb-3" style="display: none;">
    <div class="card-header">
      <h5>Validar Archivo</h5>
    </div>
<div class="card-body">

  <?php 
    $form = ActiveForm::begin();
  ?>
      <?= $form->field($modelForm, 'fileId', ['options' => ['style' => 'display: none;']])->textInput() ?>
      <?= $form->field($modelForm, 'idValid')->dropDownList($modelForm->getValidationStatusList(),[]) ?>
      <?= $form->field($modelForm, 'expireDate', ['options' => ['id' => 'expiredate_field', 'style' => 'display: none;']])->input('datetime-local') ?>
        <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
</div> 
  <?php 
    ActiveForm::end();
  ?>
  </div>
</div>

