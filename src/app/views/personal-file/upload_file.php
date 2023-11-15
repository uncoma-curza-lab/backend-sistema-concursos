<?php

use app\models\PersonalFile;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Cargar Archivos';
$aceptedFiles = '';
foreach(PersonalFile::ACCEPTED_EXTENSIONS as $val){
    $aceptedFiles .= "$val, ";
}
$aceptedFiles = substr($aceptedFiles, 0, -2);
?>

<div class="file-form">

<h3><?= $this->title ?></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="mb-3">
    
    <?= $form->field($modelForm, 'description')->input('text', ['class' => 'form-control']) ?>
    <?= $form->field($modelForm, 'document_type_code')->dropDownList($documentsTypeList,['class'=>"form-control", 'prompt' => 'Seleccione...']) ?>

    <?= Html::label(\Yii::t('models/personal-files', 'file'),'file', ['class'=>'form-label'])?>
    <?= Html::fileInput('file', null, ['id' => 'file', 'class'=>"form-control", 'maxSize' => PersonalFile::UPLOAD_MAX_SIZE, 'required' => 'required', 'accept' => $aceptedFiles]) ?>
</div>
    <button class="btn btn-success">Cargar</button>

<?php ActiveForm::end() ?>

</div>
<?php 
$maxSizeJs = <<< JS
    $('#file').change((e) => {
        const input = event.target;
        if (input.files && input.files[0]) {
            const maxSize = input.attributes.maxSize.value;
            const maxAllowedSize = maxSize * 1024;
            if (input.files[0].size > maxAllowedSize) {
                alert('El Archivo es demasiado grande. Debe ser de máximo ' + (maxSize / 1024) + 'MB');
                input.value = ''
            }
        }
    })
JS;
$this->registerJs($maxSizeJs, View::POS_LOAD);
?>
