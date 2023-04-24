<?php

use app\models\Activity;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$alertText = '';
if(\Yii::$app->user->isGuest){
    $alertText = 'Debe ' . Html::tag('a', 'Registrarse', ['href' => Url::to('/signup')]) . 
        ' o ' . Html::tag('a', 'Iniciar Sesión', ['href' => Url::to('/login')]) . ' para inscribirse a un concurso';
}elseif(!\Yii::$app->user->identity->isValid()){
    $alertText = 'Debe completar todos sus datos personales para inscribirse a un concurso: ' . Html::tag('a', 'Completar Datos', [
            'href' => Url::to('/user/profile'),
        ]);
}

if ($contest!=null):
  $department = $contest->getEvaluationDepartament()->name ?? null;
  $th = '';
  $td = '';
  $th .= $department ? '<th scope="col">Departamento</th>' : '';
  $td .= $department ? "<td name='departamento'>$department</td>" : '';
  if($contest->isTeacher()){
    $th .= '<th scope="col">Área</th><th scope="col">Orientación</th>';
    $td .= "<td name='area'>{$contest->getAreaName()}</td><td name='orientacion'>{$contest->getOrientationName()}</td>";
  } else if ($contest->isInstitutionalProject()){
    $th .= '<th scope="col">Proyecto Institucional</th>';
    $td .= '<td name="proyecto_institucional">' . $contest->institutionalProject->name . '</td>';
  }
  if($contest->hasCourseName()){
    $th .= '<th scope="col">Asignatura</th>';
    $td .= '<td name="asignatura">' . $contest->getCourseName() . '</td>';
  }

?>
<div class="contaner">
    <?php 
    if($alertText):
    ?>
    <div class="alert alert-warning" role="alert">
        <?= $alertText ?>
    </div>
    <?php 
       endif;
    ?>

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
          <?= $th ?>          
          <th scope="col">Cargos</th>
          <th scope="col">Categoría</th>
          <th scope="col">Dedicación</th>
          <th scope="col">Caracter</th>
        </tr>
      </thead>
      <tbody>
        <tr>      
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
      <h3>Inscripciones</h3>
       <ul>
            <?php
                $initDate = $contest->init_date;
                $enrollmentDate = $contest->enrollment_date_end;
            ?>
            <li>Se recibirán inscripciones desde el <?= $initDate?> 
            hasta el  <?= $enrollmentDate ?></li>
        </ul>
      </div>  
     <div>
        <?= $contest->description;  ?>
        <div>
          <h4>Doucumentos</h4>
          <ul>
          <?php foreach($attachedFiles as $file): ?>
          <li>
            Siendo la fecha <?= $file->published_at ?> se publica <?= $file->documentType->name . ' - ' . $file->name ?> 
            <a href="<?= Url::to(['@web/' . $file->path]) ?>" class="btn btn-primary" target="_blank">Descargar</a>
          </li>
          <?php endforeach; ?>

          </ul>
        </div>
        <div>
            <?php if ($contest->isHelper() && $contest->hasCourseName()): 
              $programUrl = $contest->getProgramUrl();
            ?>
            <h5> Programa </h5>
                <p>
                Programa: <a href="<?= $programUrl; ?>" <?= !$programUrl ? 'data-toggle="modal" data-target="#modalNoProgram"' : '' ?>>Descargar Programa</a> 
                </p>
                    
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
<?php
  Modal::begin([
    'id'=>'modalNoProgram',
    'class' =>'modal',
    'size' => 'modal-md',
    'title' => 'No hay un programa Vigente',
  ]);
  echo '<div><p>No se encuentra disponible un programa vigente. Contacte al departamento docente para más información: <a href="mailto:departamento.docente.curza@gmail.com"> departamento.docente.curza@gmail.com </a></p></div>';
  Modal::end();
?>

<?php else: ?>
<div class="container">
<h2><?= \Yii::t('app', 'contest_not_found') ?></h2>
</div>
<?php endif; ?>

<?php 
$alertNoProgram = <<< 'JS'
var notFindProgram = (event) => {
    event.preventDefault();
    $('#modalNoProgram').modal('show');
    console.log($('#modalNoProgram'))
}
JS;

$this->registerJs($alertNoProgram, View::POS_HEAD);
?>
