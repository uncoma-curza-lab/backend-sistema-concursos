<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ayuda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
<h2>Guías de usuario</h2>
    <p>
        A contunuación presentamos las guías para el usuario del sistema de concursos:
    </p>
    <ul>
        <li>
            <a href="<?= Url::to(['@web/documents/PostulantGide.pdf']) ?>" target="_blank">Guía del Postulante</a>
        </li>
    </ul>


<h2>Resoluciones</h2>
<h3>...Area en contrucción...</h3>
</div>
