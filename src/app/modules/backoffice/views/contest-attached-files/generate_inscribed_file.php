<?php

use dosamigos\tinymce\TinyMce;
use yii\bootstrap4\Modal;
use yii\web\View;
use yii\widgets\ActiveForm;
?>

<div class="contests-form">

<h3>Generar Nomina de Inscriptos al concurso: <i> <?= $contest->name ?></i></h3>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'inscribedForm']]) ?>
<div class="mb-3">
        <?= $form->field($modelForm, 'text', [
            'options' => [
                'class' => 'form-group col-md-12',
                'id' => 'form-text',
            ]
        ])->widget(TinyMce::class, [
          'options' => ['rows' => 20, 'value' => $content, 'id' => 'text-content',],
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

<?php ActiveForm::end() ?>
<button class="btn btn-success submit">Generar</button>
<button class="btn btn-info" id="previewBtn">Vista Previa</button>


<?php
  Modal::begin([
    'id'=>'previewModal',
    'class' =>'modal',
    'size' => 'modal-xl',
    'title' => 'Vista Previa Nomina de incriptos',
  ]);
?>
  <embed id="embed" src="" width="100%" height="600">

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success submit">Generar</button>
  </div>
<?php
  Modal::end();
?>
</div>

<?php 
$preview = <<< 'JS'
$('#previewBtn').click(() => {
  const text = $('#text-content_ifr')[0].contentDocument.body.innerHTML;
  const csrfParam = document.querySelector('meta[name="csrf-param"]').content;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  fetch('/backoffice/contest-attached-files/inscribed-preview', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      [csrfParam]: csrfToken,
      text: text 
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Error en la petición');
    }
    response.blob()
      .then( (blobResponse) => {
        let newBlob = new Blob([blobResponse], {type: "application/pdf"})
        const data = window.URL.createObjectURL(newBlob);
        let embed = document.getElementById('embed');
        embed.src = data;
        $('#previewModal').modal('show');
      })
  })
})
JS;

$sendForm = <<< 'JS'
  $('.submit').click(() => {
    $('#inscribedForm').submit();
  })
JS;

$this->registerJs($preview, View::POS_READY);
$this->registerJs($sendForm, View::POS_READY);

?>
