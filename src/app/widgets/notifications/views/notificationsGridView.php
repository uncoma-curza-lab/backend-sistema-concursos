<?php
use yii\helpers\Url;
?>
<div class="container list-group">
    <?php
        foreach ($models as $model): 
            $readBackground = $model->read ? 'list-group-item-secondary' : '';
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
                   <button class="btn btn-info"><i class="bi bi-envelope-open"></i></button>
               </div>
            </div>
        </div>
        
    <?php 
        endforeach;
    ?>
</div>
