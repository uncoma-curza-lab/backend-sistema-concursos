<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('menu', 'help');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-help">

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


    <h2>Reglamentaciones</h2>
    <p>
        Reglamentaciones vigentes para la incripción a concursos.
    </p>
    <ul>
        <li>
            <a href="<?= Url::to(['@web/documents/regulations/ord_813_2021_52.pdf']) ?>" target="_blank">Ordenanza N.º 813/2021 - Reglamento de Concursos para Profesores Regulares</a>
        </li>
        <li>
            <a href="<?= Url::to(['@web/documents/regulations/resol_0234_2018.pdf']) ?>" target="_blank">Resolución N.º 234/2018 – Reglamento de Concurso para Auxiliares de Departamento y Coordinación de Carrera</a>
        </li>
        <li>
            <a href="<?= Url::to(['@web/documents/regulations/resol_0047_CD2017.pdf']) ?>" target="_blank">Resolución N.º 047/2017 - Reglamento de Concurso Ayudante Alumno Ad Honorem</a>
        </li>
        <li>
            <a href="<?= Url::to(['@web/documents/regulations/resol_0048_CD2017.pdf']) ?>" target="_blank">Resolución N.º 048/2017 - Reglamento de Concurso Graduado en Formación Docente Ad Honorem</a>
        </li>
    </ul>

</div>
