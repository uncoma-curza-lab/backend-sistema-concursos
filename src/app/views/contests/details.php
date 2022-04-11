<?php

use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($contest!=null):
?>
<div class="contaner">
  <h2>Concurso - <?= $contest->name ?></h2>
  <div class="container">
    <p>
        El Centro Universitario Regional Zona Atlántica de la Universidad Nacional 
        del Comahue comunica que se llama a concurso de antecedentes para cubrir 
        cargos docentes para el año académico 2021.
    </p>
  </div>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Departamento</th>
          <th scope="col">Área</th>
          <th scope="col">Orientación</th>
          <th scope="col">Asignatura</th>
          <th scope="col">Cargos</th>
          <th scope="col">Categoría</th>
          <th scope="col">Dedicación</th>
        </tr>
      </thead>
      <tbody>
        <tr>      
        <td name="departamento"><?= $contest->getEvaluationDepartament()->name ?? 'unavailable' ?></td>
          <td name="area"><?= $contest->area->name ?></td>
          <td name="orientacion"><?= $contest->orientation->name ?></td>
          <td name="asignatura"><?= $contest->course->name ?? 'unavailable' ?></td>
          <td name="cargos"><?= $contest->qty ?></td>
          <td name="categoria"><?= $contest->categoryType->name ?></td>
          <td name="dedicacion"><?= $contest->workingDayType->name ?></td>      
        </tr>  
      </tbody>
    </table>
  </div>
  <div class="container">
    <div class="row">
<div>
      <h3>Incripciones</h3>
       <ul>
            <?php
                $initDate = date_create($contest->init_date);
                $enrollmentDate = date_create($contest->enrollment_date_end);        
            ?>
            <li>Se recibirán incripciones desde el <?= date_format($initDate, "d-m-Y")?> 
            hasta el  <?= date_format($enrollmentDate, "d-m-Y")?></li>
        </ul>
    </div>  
     <div>
        <?= $contest->description;  ?>
    </div> 
   </div>

  </div>
  <br>
  <?php if ($contest->canPostulate()): ?>
    <?= Html::button('<i class="bi bi-person-plus-fill"></i> Postularse con Modal', [
      'value' => Url::to(['postulations/contest-inscription', 'slug' => $contest->code]),
      'class' => 'btn btn-info',
      'id' => 'modalButton'
    ]);  ?>
  <?php endif; ?>
  <?php if ($contest->isResolutionPublished()): ?>
    <?= Html::a('<span class="bi bi-file-earmark-arrow-down-fill" aria-hidden="true"></span> Descargar dictamen',
      Url::to(['postulations/download-resolution', 'slug' => $contest->code]),
      ['class' => 'btn btn-success'],
    );  ?>
  <?php endif ?>
</div>
<!-- Modal -->
<?php
  Modal::begin([
    'id'=>'modal',
    'class' =>'modal',
    'size' => 'modal-md',
  ]);
  echo "<div id='modalContent'></div>";
  Modal::end();
?>
<?php else: ?>
<div class="container">
  <h2>Concurso NO Encontrado</h2>
</div>
<?php endif; ?>

