<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<div class="contests-form">

<h3>Cambiar estado del concurso: <i> <?= $model->name ?></i></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($modelForm, 'resolution_file_path')->fileInput() ?>

    <button>Enviar</button>

<?php ActiveForm::end() ?>

</div>
