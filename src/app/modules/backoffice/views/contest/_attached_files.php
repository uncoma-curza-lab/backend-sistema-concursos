<?php 
use yii\helpers\Url;
?>
<div class="card">
    <div class="card-body">
    <h5 class="card-title"><?= Yii::t('backoffice', 'attached_files') ?></h5>
      <div class="list-group">
          <?php
            foreach ($attachedFiles as $file): 
                //TODO - Delete method
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
                          <a class="btn <?= $btn ?>" href="<?= url::to(['attached_files/' . $file->id]) ?>" title="<?= $toPublish ?>"><i class="bi <?= $icon ?>"></i></a>
                          <a class="btn btn-danger" href="<?= url::to(['@web/' . $file->path]) ?>" title="Borrar"><i class="bi bi-trash"></i></a>
                       </div>
                    </div>
                </div>
          <?php 
          endforeach;
          ?>
      </div>
    </div>
</div>

