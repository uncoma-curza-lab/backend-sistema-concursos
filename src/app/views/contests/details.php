<?php

use app\models\Activity;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($contest!=null):
  $th = '';
  $td = '';
  if($contest->isTeacher()){
    $th = '<th scope="col">Área</th><th scope="col">Orientación</th>';
    $td = "<td name='area'>{$contest->getAreaName()}</td><td name='orientacion'>{$contest->getOrientationName()}</td>";
  }
  if($contest->hasCourseName()){
    $th .= '<th scope="col">Asignatura</th>';
    $td .= '<td name="asignatura">' . $contest->getCourseName() . '</td>';
  }

?>
<div class="contaner">
  <h2>Concurso - <?= $contest->name ?></h2>
  <div class="container">
    <p>
        <?= $contest->getIntroDetails() ?>
    </p>
  </div>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Departamento</th>
          <?= $th ?>          
          <th scope="col">Cargos</th>
          <th scope="col">Categoría</th>
          <th scope="col">Dedicación</th>
          <th scope="col">Caracter</th>
        </tr>
      </thead>
      <tbody>
        <tr>      
        <td name="departamento"><?= $contest->getEvaluationDepartament()->name ?? 'unavailable' ?></td>
          <?= $td ?>
          <td name="cargos"><?= $contest->qty ?></td>
          <td name="categoria"><?= $contest->category->code ?></td>
          <td name="dedicacion"><?= $contest->workingDayType->name ?></td>      
          <td name="caracter"><?= $contest->categoryType->name ?></td>      
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
                $initDate = $contest->init_date;
                $enrollmentDate = $contest->enrollment_date_end;
            ?>
            <li>Se recibirán incripciones desde el <?= $initDate?> 
            hasta el  <?= $enrollmentDate ?></li>
        </ul>
      </div>  
     <div>
        <?= $contest->description;  ?>
        <div>
            <?php if (count($contest->juries) > 0): ?>
            <h5> Jurado </h5>
                <?php foreach($contest->juries as $jury): ?>
                <ul>
                    <li><?= $jury->person->getFullName(); ?></li>
                </ul>
                    
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div> 
   </div>

  </div>
  <br>
  <?php if ($contest->canPostulate()): ?>
    <?= Html::button('<i class="bi bi-person-plus-fill"></i> ' . \Yii::t('app', 'inscription_button'), [
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
<h2><?= \Yii::t('app', 'contest_not_found') ?></h2>
</div>
<?php endif; ?>

