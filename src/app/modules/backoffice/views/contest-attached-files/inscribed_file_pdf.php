<?php 
    use app\models\PostulationStatus;
$workingDyaType = $contest->workingDayType->name;
$category = $contest->category->name;
$department = $contest->departament ? $contest->departament->name : $contest->evaluationDepartament->name;
$area = $contest->area ? $contest->area->name : '';
$orientation = $contest->orientation ? $contest->orientation->name : '';
?>
<html>
<body>
    <h2>ACTA</h2>
    <h2>CIERRE DE INSCRIPCIÓN</h2>
    
    <p>
    ------------En la ciudad de Viedma, siendo las 23:55 hs del día nueve (09) de septiembre del año 2022, en el Centro Universitario Regional Zona Atlántica de la Universidad Nacional del Comahue, se produce el cierre de la inscripción del llamado a concurso de ingreso, antecedentes y oposición, aprobado por Resolución del Consejo Directivo del CURZA N.º 071/2022, para un cargo de Profesor Adjunto <?= $category ?>, con dedicación <?= $workingDyaType ?>, (PAD-3) para el Área: <?= $area ?>, Orientación: <?= $orientation ?> correspondiente al Departamento de <?= $department ?>.----------------------------------------------------------------------------------------
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
