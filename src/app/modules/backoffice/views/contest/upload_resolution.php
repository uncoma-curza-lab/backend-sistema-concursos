<?php
use yii\widgets\ActiveForm;
?>

<div class="contests-form">

<h3>Cargar Dictamen del concurso: <i> <?= $model->name ?></i></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<div class="mb-3">
    <?= $form->field($modelForm, 'resolution_file_path')->fileInput(['class'=>"form-control"])->label('Dictamen:', ['class'=>'form-label']) ?>
</div>
    <button class="btn btn-success">Enviar</button>

<?php ActiveForm::end() ?>

</div>
