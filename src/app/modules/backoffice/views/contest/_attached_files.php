<?php 
use yii\helpers\Url;
?>
<div id="attached_files" class="card">
    <div class="card-body">
    <h5 class="card-title"><?= Yii::t('backoffice', 'attached_files') ?></h5>
      <div class="list-group">
          <?php
            foreach ($attachedFiles as $file): 
                  $icon = 'bi-eye';
                  $btn = 'btn-success';
                  $toPublish = 'Publicar';
  
                  if($file->published){
                      $icon = 'bi-eye-slash';
                      $btn = 'btn-warning';
                      $toPublish = 'Marcar como Borrador';
                  }
                  ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col">
                          <div class="d-flex w-100 justify-content-start">
                            <i class="bi bi-file-earmark-text-fill" aria-hidden="true"></i> 
                            <?= $file->documentType->name ?> - 
                            <?= $file->name ?>
                          </div>
                       </div>
                       <div class="col-md-auto">
                          <a class="btn btn-info" href="<?= Url::to(['@web/' . $file->path]) ?>" target="_blank" title="Ver"><i class="bi bi-file-earmark-arrow-down"></i></a>
                          <a class="btn <?= $btn ?>" href="<?= url::to(['contest-attached-files/publish', 'fileId' => $file->id, 'slug' => $contest->code]) ?>" title="<?= $toPublish ?>"><i class="bi <?= $icon ?>"></i></a>
                          <a class="btn btn-danger" data-confirm="<?= Yii::t('backoffice', 'question_delete') ?>" href="<?= url::to(['contest-attached-files/delete', 'fileId' => $file->id, 'slug' => $contest->code]) ?>" title="Borrar"><i class="bi bi-trash"></i></a>
                       </div>
                    </div>
                </div>
          <?php 
          endforeach;
          ?>
      </div>
    </div>
</div>

