<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Archivos del Concurso';

?>
<div class="contest-files-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php
    if($shareUrl):
?>
    <iframe src="<?= $shareUrl ?>" width="100%" height="350px" title="Contest Files Iframe">
</iframe>
 
<?php
    else:
?>
    <div class="alert alert-warning" role="alert">
        No tiene acceso a los archivos del concurso.
    </div>
<?php
    endif
?>
    <a href="<?= Url::to('my-postulations') ?>" class="btn btn-primary" role="button">Regresar</a>


</div>
