<?php

use app\models\PersonalFile;
use yii\helpers\Html;
use yii\helpers\Url;

$files = $dataProvider->getModels();
?>
<div class="list-group">
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
            <div class="list-group-item">
                <div class="row">
                    <div class="col">
                      <div class="d-flex w-100 justify-content-between">
                        <div>
                          <i class="bi bi-file-earmark-text-fill" aria-hidden="true"></i> 
                          <?= $file->documentType->name ?> 
                        </div>
                        <div>
                            <div class="text-right">
                                <small>Subido el: <?= $file->created_at ?></small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-<?= $badge ?>">
                                    <?= $status ?>
                                </span>
                                <small><?= $file->valid_until ? 'Fecha de Expiración: ' . $file->valid_until : '' ?></small>
                            </div>
                        </div>
                      </div>
                   </div>
                   <div class="col-md-auto">
                      <a class="btn btn-info" href="<?= Url::to(['@web/' . $file->path]) ?>" target="_blank" title="Ver"><i class="bi bi-file-earmark-arrow-down"></i></a>
                      <?= Html::a('<i class="bi bi-trash"></i>', ['personal-file/delete', 'fileId' => $file->id], [
                        'class' => "btn btn-danger",
                        'title' => Yii::t('backoffice', 'Eliminar'),
                          'data' => [
                              'confirm' => Yii::t('models/personal-files', 'question_delete'),
                              'method' => 'post',
                          ],
                      ]);
                    ?>
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

