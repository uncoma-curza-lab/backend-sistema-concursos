<?php

use app\widgets\files\FilesGrid;
use yii\helpers\Html;
?>

<div class="container">
    <?= $this->render('/person/read_only_profile', ['profile' => $profile]) ?>
</div>

<div class="container">
    <?= FilesGrid::widget([
        'dataProvider' => $files,
        'actionButtons' => [
            'download' => true,
        ]
        ]) ?>
</div>

    <div class="row justify-content-end">
      <?= Html::a('Volver', \Yii::$app->request->referrer, ['class'=>'btn btn-info float-right']) ?>
    </div>

</div>