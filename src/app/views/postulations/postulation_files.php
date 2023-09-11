<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Archivos de la Postulación';

?>
<div class="postulations-files-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/personal-file/_files_list', ['files' => $files]) ?>
    <a href="<?= Url::to('my-postulations') ?>" class="btn btn-primary" role="button">Regresar</a>


</div>
