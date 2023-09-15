<?php

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

    <?= $this->render('/personal-file/_files_list', ['files' => $files]) ?>
    <a href="<?= Url::to('my-postulations') ?>" class="btn btn-primary" role="button">Regresar</a>


</div>
