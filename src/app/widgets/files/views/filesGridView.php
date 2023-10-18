<?php

use app\models\PersonalFile;
use yii\helpers\Html;
use yii\helpers\Url;

$files = $dataProvider->getModels();
?>

<?php if ($options['search']){
    echo $this->render('_search', []);
}
?>

<div class="row row-cols-1 row-cols-md-4">
    <?php
      if($files):
        foreach ($files as $file): 
              $badge = 'info';
              $status = 'Sin Validar';
              $validEndDate = '';
              if($file->isValid()){
                  $badge = 'success';
                  $status = 'Valido';
              }
              if($file->isStatus(PersonalFile::UNVALIDATED)){
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
                      <?= $file->documentType->name ?> 
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
                    <?php if($actionButtons['download']): ?>
                       <a class="btn btn-info" href="<?= Url::to(['@web/' . $file->path]) ?>" target="_blank" title="Ver"><i class="bi bi-file-earmark-arrow-down"></i></a>
                    <?php 
                        endif;
                        if($actionButtons['delete']): 
                    ?>
                       <?= Html::a('<i class="bi bi-trash"></i>', ['personal-file/delete', 'fileId' => $file->id], [
                         'class' => "btn btn-danger",
                         'title' => Yii::t('backoffice', 'Eliminar'),
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

