<?php

use yii\widgets\ActiveForm;
?>

<div class="contests-form">

<h3>Cargar Documento al concurso: <i> <?= $contest->name ?></i></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="mb-3">
    <?= $form->field($modelForm, 'name')->textInput(['class'=>"form-control"]) ?>
    
    <div class="form-row">
        <div class="col">
            <?= $form->field($modelForm, 'document_type_id')->dropDownList($documentsTypeList,['class'=>"form-control", 'prompt' => 'Seleccione...']) ?>
        </div>
    
        <div class="col">
            <?= $form->field($modelForm, 'responsible_id')->dropDownList($responsiblesList,['class'=>"form-control", 'prompt' => 'Seleccione...']) ?>
        </div>
    </div>

    <?= $form->field($modelForm, 'resolution_file')->fileInput(['class'=>"form-control"])->label('File:', ['class'=>'form-label']) ?>
</div>
    <button class="btn btn-success">Enviar</button>

<?php ActiveForm::end() ?>

</div>
