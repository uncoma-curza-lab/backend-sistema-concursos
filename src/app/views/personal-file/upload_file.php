<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Cargar Archivos';
?>

<div class="file-form">

<h3><?= $this->title ?></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="mb-3">
    
    <?= $form->field($modelForm, 'description')->input('text', ['class' => 'form-control']) ?>
    <?= $form->field($modelForm, 'document_type_code')->dropDownList($documentsTypeList,['class'=>"form-control", 'prompt' => 'Seleccione...']) ?>

    <?= Html::label('File:','file', ['class'=>'form-label'])?>
    <?= Html::fileInput('file', null, ['class'=>"form-control"]) ?>
</div>
    <button class="btn btn-success">Cargar</button>

<?php ActiveForm::end() ?>

</div>
