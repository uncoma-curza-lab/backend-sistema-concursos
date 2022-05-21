<?php

use yii\helpers\Html;

$this->title = 'Archivos de la Postulación';

//--------------------------------------------
//-------FIX MOMENTANEO DE URL---------------
//-----------------------------------------
$shareUrl = str_replace("cloud", "localhost:8080", $shareUrl);
//-------------------------------------------
?>
<div class="postulations-files-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <iframe src="<?= $shareUrl ?>" width="100%" height="500" title="Postualtion Files Iframe">
</iframe>
 

</div>
