<?php

use app\models\PersonalFile;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$files = $dataProvider->getModels();
$hasDelete = $actionButtons['delete'];
$hasToValidate = !!$actionButtons['validation'];
?>

<?php if ($options['search']){
    echo $this->render('_search', []);
}
?>

<div class="row row-cols-1 row-cols-md-4">
    <?php
      if($files):
        foreach ($files as $file):
          $typeName = $file->documentType->name;
          $fileId = $file->id;
          $badge = 'info';
          $status = 'Sin Validar';
          $validEndDate = '';
          if($file->isValid()){
              $badge = 'success';
              $status = 'Valido';
          }
          if($file->isStatus(PersonalFile::INVALID)){
            $badge = 'danger';
            $status = 'Invalido';
          }
          if($file->isExpired()){
            $badge = 'warning';
            $status = 'Vencido';
          }
        ?>
        <div class="col mb-4">
            <div class="card h-100">
                <h5 class="card-header">
                  <i class="bi bi-file-earmark-text-fill" aria-hidden="true"></i>
                  <?= $typeName ?>
                </h5>
                <div class="card-body">
                    <h5 class="card-title"><?= $file->description ?></h5>
                    <p class="card-text">
                        <small>Subido el: <?= $file->created_at ?></small>
                    </p>
                    <div class="text-center">
                        <span class="badge badge-<?= $badge ?>">
                            <?= $status ?>
                        </span>
                        <div>
                            <small><?= $file->valid_until ? 'Fecha de Expiración: ' . $file->valid_until : '' ?></small>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                <?php if($actionButtons['view']): ?>
                  <button class="btn btn-success" id="previewBtn<?= $file->id ?>" title="Ver" data-toggle="modal" data-target="#previewModal"><i class="bi bi-eye"></i></button>
                <?php
                  $filePath = Url::to(['@web/' . $file->path]);
                  $showValidationForm = $file->isStatus(PersonalFile::UNVALIDATED) ? 'block' : 'none';

                  $previewScript = <<< EOD
                  $('#previewBtn$file->id').click(() => {
                    $('#formDiv').css('display', '$showValidationForm');
                    $('#previewModal-label').text('Vista Previa $typeName');
                    $('#personalfilevalidationform-fileid').val($fileId);
                    $('#embed').attr('src', '$filePath');
                    $("#loading").hide();
                  })
                  EOD;
                  $this->registerJs($previewScript, View::POS_READY);
                ?>
                <?php
                    endif;
                    if($actionButtons['download']):
                ?>
                   <a class="btn btn-warning" href="<?= Url::to(['@web/' . $file->path]) ?>" target="_blank" title="Descargar"><i class="bi bi-file-earmark-arrow-down"></i></a>
                <?php
                    endif;
                    if((is_bool($hasDelete) && $hasDelete) || ($hasDelete instanceof Closure && $hasDelete($file))):
                ?>
                   <?= Html::a('<i class="bi bi-trash"></i>', ['personal-file/delete', 'fileId' => $file->id], [
                     'class' => "btn btn-danger",
                     'title' => ucfirst(Yii::t('backoffice', 'delete')),
                       'data' => [
                           'confirm' => Yii::t('models/personal-files', 'question_delete'),
                           'method' => 'post',
                       ],
                   ]);
                 ?>
                <?php endif; ?>
                </div>
              </div>
          </div>
  <?php
      endforeach;

    else:
  ?>
      <div class="alert alert-warning" role="alert">
          No se encontraron archivos.
      </div>
  <?php
    endif;
  ?>
  </div>
  <div class="p-2">
      <?php
          echo \yii\widgets\LinkPager::widget([
              'pagination' => $dataProvider->pagination,
          ]);
      ?>
  </div>

  <?php
  if($actionButtons['view']):
    Modal::begin([
      'id'=>"previewModal",
      'class' =>'modal',
      'size' => 'modal-xl',
      'title' => "Vista Previa",
    ]);
  ?>
    <div class="d-flex justify-content-center">
    <div id="loading" class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div id="formDiv">
    <?php
          if($hasToValidate){
            $modelForm = $actionButtons['validation']['form'];
            echo $this->render('_validation_form', ['modelForm' => $modelForm]);
          }
    ?>
    </div>
    <embed id="embed" src="" width="100%" height="600">

    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Yii::t('backoffice', 'close_button') ?></button>
    </div>
  <?php
    Modal::end();
    endif;
  ?>
