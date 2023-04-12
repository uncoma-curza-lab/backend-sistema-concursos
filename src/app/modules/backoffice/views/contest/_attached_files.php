<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$teachDepartmenRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament');
$adminRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin');
$presidentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $contest->code]);

$today = date_create();
$enrollment_date_end = date_create($contest->enrollment_date_end);
$approvalResolution = $contest->getApprovalResolution();
$approvalResolutionIsPublished = $approvalResolution ? $approvalResolution->isPublished() : false;
$disableInscibedFile = ($today < $enrollment_date_end || !$approvalResolutionIsPublished || $contest->getInscribedPostualtion()) ? 'disabled' : '';
?>
<div id="attached_files" class="card">
    <div class="card-body">
    <h3 class="card-title"><?= Yii::t('backoffice', 'attached_files') ?></h3>
    <p>
        <?php 
                if ($teachDepartmenRol || $adminRol || $presidentRol):
        ?>

        <?= Html::a(
                !$presidentRol ? Yii::t('backoffice', 'attach_file') : Yii::t('backoffice', 'attach_veredict_file'),
                ['/backoffice/contest-attached-files/attach-file', 'slug' => $contest->code ],
                    [
                        'class' => 'btn btn-primary',
                    ]);
          endif;
        ?>

        <?php 
                if ($teachDepartmenRol || $adminRol):
        ?>

        <?= Html::a(
                Yii::t('backoffice', 'generate_inscribed_file'),
                ['/backoffice/contest-attached-files/generate-inscribed-file', 'slug' => $contest->code ],
                    [
                        'class' => "btn btn-success $disableInscibedFile",
                    ]); 
        endif;
        ?>
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
                      <?php 
                              if ($teachDepartmenRol || $adminRol):
                      ?>
                              <?= Html::a("<i class='bi $icon'></i>", ['contest-attached-files/publish', 'fileId' => $file->id, 'slug' => $contest->code],[
                                'class' => "btn $btn $publishDisable",
                                'title' => $toPublish,
                              ]) ?>
                      <?php 
                              endif;
                              if(
                                  $teachDepartmenRol
                                  ||
                                  $adminRol
                                  ||
                                  (
                                    $presidentRol
                                    &&
                                    $file->isVeredict()
                                  )
                              ):

                      ?>
                              <?= Html::a('<i class="bi bi-trash"></i>', ['contest-attached-files/delete', 'fileId' => $file->id, 'slug' => $contest->code], [
                                'class' => "btn btn-danger $deleteDisable",
                                'title' => Yii::t('backoffice', 'Eliminar'),
                                  'data' => [
                                      'confirm' => Yii::t('backoffice', 'question_delete'),
                                      'method' => 'post',
                                  ],
                              ]);
                              endif;
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

