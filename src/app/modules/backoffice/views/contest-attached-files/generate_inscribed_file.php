<?php

use dosamigos\tinymce\TinyMce;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
?>

<div class="contests-form">

<h3>Generar Nomina de Inscriptos al concurso: <i> <?= $contest->name ?></i></h3>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'inscribedForm']]) ?>
<div class="mb-3">
        <?= $form->field($modelForm, 'text', [
            'options' => [
                'class' => 'form-group col-md-12',
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
<button class="btn btn-success" onclick="sendForm()">Generar</button>
<button class="btn btn-info" onclick="preview()">Vista Previa</button>


<?php
  Modal::begin([
    'id'=>'previewModal',
    'class' =>'modal',
    'size' => 'modal-xl',
    'title' => 'Preview Nomina de incriptos',
  ]);
?>
  <embed id="embed" src="" width="100%" height="600">

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" onclick="sendForm()">Generar</button>
  </div>
<?php
  Modal::end();
?>
<script>
function preview() {
  const text = $('#text-content')[0].value;
  fetch('/backoffice/contest-attached-files/inscribed-preview', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
      text: text 
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Error en la petición');
    }
    response.blob()
      .then(
        showFile
      )
  })
}
function showFile(blobResponse){
  let newBlob = new Blob([blobResponse], {type: "application/pdf"})
  const data = window.URL.createObjectURL(newBlob);
  var embed = document.getElementById('embed');
  embed.src = data;
  $('#previewModal').modal('show');
}

function sendForm(){
  $('#inscribedForm').submit();
}
</script>
</div>
