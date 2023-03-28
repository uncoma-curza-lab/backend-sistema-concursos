<?php

use app\models\InscribedContestAttachedFile;
use app\models\PostulationStatus;

$date = InscribedContestAttachedFile::getParcedDateToNoteFormat();
$workingDayType = $contest->workingDayType->name;
$workingDayTypeCode = $contest->workingDayType->code;
$category = $contest->category->name;
$categoryCode = $contest->category->code;
$categoryNumber = 1;
if ($workingDayTypeCode === 'parcial'){
    $categoryNumber = 2;
} else if ($workingDayTypeCode === 'simple'){
    $categoryNumber = 3;
}
$department = $contest->departament ? $contest->departament->name : $contest->evaluationDepartament->name;
$area = $contest->area ? $contest->area->name : '';
$orientation = $contest->orientation ? $contest->orientation->name : '';
$areaText = '';
if($area){
    $areaText = "para el Área: $area, Orientación: $orientation ";
}
$categoryTypeCode = $contest->categoryType->code;
$contestTypeText = 'de ingreso, antecedentes y oposición';
if($categoryTypeCode === 'interinos' || $categoryTypeCode === 'suplente'){
    $contestTypeText = 'para cargos interinos y suplentes';
} else if ($categoryTypeCode === 'ad-honorem') {
    $contestTypeText = 'para cargos AD HONOREM';
}
?>
<html>
<body>
    <h2 style="text-align: center;">ACTA</h2>
    <h2 style="text-align: center;">CIERRE DE INSCRIPCIÓN</h2>
    
    <p>
    ------------En la ciudad de Viedma, siendo las 23:55 hs del día <?= $date ?>, en el Centro Universitario Regional Zona Atlántica de la Universidad Nacional del Comahue, se produce el cierre de la inscripción del llamado a concurso <?= $contestTypeText ?>, aprobado por Resolución del Consejo Directivo del CURZA N.º 071/2022, para un cargo de <?= $category ?>, con dedicación <?= $workingDayType ?>, (<?= $categoryCode ?>-<?= $categoryNumber ?>) <?= $areaText ?> correspondiente al Departamento de <?= $department ?>.----------------------------------------------------------------------------------------
    </p>
    
    <p>
    Se registra las siguientes inscripciones:--------------------------------------------------
    </p>
    <ul>
    <?php
        foreach ($contest->postulations as $postulation) :
            if($postulation->status === PostulationStatus::ACCEPTED):
    ?>
            <li>
                <?= $postulation->person->last_name . ', ' . $postulation->person->first_name ?> DNI N° <?= $postulation->person->dni ?>
            </li>
    <?php 
                endif;
            endforeach;
    ?>
    </ul>
    <p>
    ---No siendo para mas se da por finalizado el correspondiente acto.-------
    </p>
</body>
</html>
