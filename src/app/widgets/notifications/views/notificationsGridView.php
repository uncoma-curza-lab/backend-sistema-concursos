<?php

use app\models\Notification;
use yii\helpers\Url;
use yii\helpers\Html;
$models = $dataProvider->getModels();
$disabled = !Notification::find()->countUnreadSessionUser() ? 'disabled' : '';
?>
<div class="container list-group">
    <div class="d-flex p-2">
        <?= Html::a('<i class="bi bi-envelope-open"></i> Marcar todas como leídas', ['all-read'], ['class' => "btn btn-info $disabled"]) ?>
        <form action="" method="get" class="ml-3">
            <select name="pagination" onchange="this.form.submit()" class="form-control">
              <option disabled selected hidden>Notificaciones por página</option>
              <option value="5">Mostrar hasta 5 elementos</option>
              <option value="10">Mostrar hasta 10 elementos</option>
              <option value="25">Mostrar hasta 25 elementos</option>
              <option value="50">Mostrar hasta 50 elementos</option>
              <option value="100">Mostrar hasta 100 elementos</option>
            </select>
        </form>
    </div>
    <div class="p-2">
    
        <?php
            foreach ($models as $model): 
                $readBackground = '';
                $icon = 'bi-envelope-open';
                $btn = 'btn-info';
                $markAs = 'Marcar como leida';

                if($model->read){
                    $readBackground = 'list-group-item-secondary';
                    $icon = 'bi-envelope';
                    $btn = 'btn-secondary';
                    $markAs = 'Marcar como no leida';
                }
        ?>
            <div class="list-group-item <?= $readBackground ?>">
                <div class="row">
                    <div class="col">
                      <div class="d-flex w-100 justify-content-between">
                          <?= $model->message ?>
                          <small><?= $model->timestamp ?></small>
                      </div>
                   </div>
                   <div class="col-md-auto">
                       <a href="<?= Url::to("/notifications/read/$model->id") ?>" class="btn <?= $btn ?>" title="<?= $markAs ?>"><i class="bi <?= $icon ?>"></i></a>
                       <a href="<?= Url::to($model->url) ?>" class="btn btn-warning" title="Ver"><i class="bi bi-eye"></i></a>
                   </div>
                </div>
            </div>
            
        <?php 
            endforeach;
        ?>

    </div>
    <div class="p-2">
        <?php 
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]);
        ?>
    </div>
</div>
