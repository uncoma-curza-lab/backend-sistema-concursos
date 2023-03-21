<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
?>
<div id="attached_files" class="card">
    <div class="card-body">
    <h3 class="card-title"><?= Yii::t('backoffice', 'attached_files') ?></h3>
    <p>
        <?= Html::a(
                Yii::t('backoffice', 'attach_file'),
                ['/backoffice/contest-attached-files/attach-file', 'slug' => $contest->code ],
                    [
                        'class' => 'btn btn-success',
        ]) ?>
    </p>

      <div class="list-group">
          <?php
            foreach ($attachedFiles as $file): 
                  $icon = 'bi-eye';
                  $btn = 'btn-success';
                  $badge = 'warning';
                  $status = 'Borrador';
                  $toPublish = 'Publicar';
                  $publishDisable = '';
                  $deleteDisable = !$file->canDelete() ? 'disabled' : '';
  
                  if($file->published){
                      $icon = 'bi-eye-slash';
                      $btn = 'btn-warning';
                      $toPublish = 'Marcar como Borrador';
                      $badge = 'success';
                      $status = 'Publicado';
                      $publishDisable = !$file->canUnPublish() ? 'disabled' : '';
                  }
                  ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col">
                          <div class="d-flex w-100 justify-content-between">
                            <div>
                              <i class="bi bi-file-earmark-text-fill" aria-hidden="true"></i> 
                              <?= $file->documentType->name ?> - 
                              <?= $file->name ?>
                            </div>
                            <div>
                                <span class="badge badge-<?= $badge ?>">
                                    <?= $status ?>
                                </span>
                                <small><?= $file->published_at ? $file->published_at : $file->created_at ?></small>
                            </div>
                          </div>
                       </div>
                       <div class="col-md-auto">
                          <a class="btn btn-info" href="<?= Url::to(['@web/' . $file->path]) ?>" target="_blank" title="Ver"><i class="bi bi-file-earmark-arrow-down"></i></a>
                          <a class="btn <?= $btn . ' ' . $publishDisable ?>" href="<?= url::to(['contest-attached-files/publish', 'fileId' => $file->id, 'slug' => $contest->code]) ?>" title="<?= $toPublish ?>"><i class="bi <?= $icon ?>"></i></a>
                          <a class="btn btn-danger <?= $deleteDisable ?>" data-confirm="<?= Yii::t('backoffice', 'question_delete') ?>" href="<?= url::to(['contest-attached-files/delete', 'fileId' => $file->id, 'slug' => $contest->code]) ?>" title="Borrar"><i class="bi bi-trash"></i></a>
                       </div>
                    </div>
                </div>
          <?php 
          endforeach;
          ?>
      </div>
    </div>
</div>

