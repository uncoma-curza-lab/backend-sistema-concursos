<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('models/personal-files', 'files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-files-index card">
    <div class="card-body">
        <h1 class="card-title">
           <?= Html::encode($this->title) ?>
        </h1>
    
        <p>
            <?= Html::a(
                Yii::t('models/personal-files', 'upload_new_file'),
                ['upload-file'],
                ['class' => 'btn btn-primary']
            ) ?>
        </p>
        <div class="list-group">
              <?php
                foreach ($files as $file): 
                      $icon = 'bi-eye';
                      $btn = 'btn-success';
                      $badge = 'warning';
                      $status = 'Sin Validar';
                      $publishDisable = '';
    
                      if($file->is_valid){
                          $icon = 'bi-eye-slash';
                          $btn = 'btn-warning';
                          $badge = 'success';
                          $status = 'Valido';
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
                                        <small><?= $file->valid_until ? 'Valido Hasta: ' . $file->valid_until : '' ?></small>
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
              ?>
          </div>
    </div>
</div>

