<?php

use dosamigos\tinymce\TinyMce;
use yii\widgets\ActiveForm;
?>

<div class="contests-form">

<h3>Generar Nomina de Inscriptos al concurso: <i> <?= $contest->name ?></i></h3>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="mb-3">
        <?= $form->field($modelForm, 'text', [
            'options' => [
                'class' => 'form-group col-md-12',
            ]
        ])->widget(TinyMce::class, [
          'options' => ['rows' => 20],
          'language' => 'es',
          'clientOptions' => [
            'plugins' => [
              'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
              'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
              'media', 'table', 'emoticons', 'template', 'help'
              ],
              'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
          ]
        ]);?>

</div>
    <button class="btn btn-success">Generar</button>

<?php ActiveForm::end() ?>

</div>
