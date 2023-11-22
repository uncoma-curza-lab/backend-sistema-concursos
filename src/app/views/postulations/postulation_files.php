<?php

use app\widgets\files\FilesGrid;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Archivos de la Postulación';

?>
<div class="postulations-files-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(
            Yii::t('models/personal-files', 'upload_new_file'),
            ['/personal-file/upload-file', 'postulationId' => $postulationId],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

    <?= 
        FilesGrid::widget([
            'dataProvider' => $files,
            'actionButtons' => [
                'download' => true,
                'delete' => fn($file) => !$file->isValid(),
            ]
        ]) 
    ?>

    <a href="<?= Url::to('/postulations/my-postulations') ?>" class="btn btn-primary" role="button">Regresar</a>


</div>
