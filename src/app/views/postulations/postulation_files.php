<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Archivos de la Postulación';

?>
<div class="postulations-files-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php
    if($shareUrl):
?>
    <iframe src="<?= $shareUrl ?>" width="100%" height="350px" title="Postualtion Files Iframe">
</iframe>
 
<?php
    else:
?>
    <div class="alert alert-warning" role="alert">
        Ya no tiene acceso a su carpeta compartida.
    </div>
<?php
    endif
?>
    <a href="<?= Url::to('my-postulations') ?>" class="btn btn-primary" role="button">Regresar</a>


</div>
