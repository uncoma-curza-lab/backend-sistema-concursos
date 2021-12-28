<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if ($data!=null):
?>
<div class="contaner">
  <h2>Concurso - <?= $data->name ?></h2>
  <div class="container">
    <p>
        Incripción al concurso.
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
          <td name="departamento">Departamento</td>
          <td name="area"><?= $dataSerializada['area']  ?></td>
          <td name="orientacion"><?= $dataSerializada['orientation'] ?></td>
          <td name="asignatura"><?= $data->course_id ?></td>
          <td name="cargos"><?= $data->qty ?></td>
          <td name="categoria"><?= $dataSerializada['categoryType'] ?></td>
          <td name="dedicacion"><?= $dataSerializada['workingDayType'] ?></td>      
        </tr>  
      </tbody>
    </table>
  </div>
  <?php 
  $form = ActiveForm::begin([
    'method'=>'post',
    'id' => 'incription',
    'enableClientValidation'=> true,
    'enableAjaxValidation' => false
  ]);
  ?>

<div class="container-md">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'terminos')->checkbox([
          'label' => 'Artículo 22º (Res. CD CURZA Nº 112/1991): La presentación de la solicitud de inscripción importa, por
parte del postulante, el conocimiento y la aceptación de las condiciones fijadas en este reglamento',
          'id' => 'terminos',
        ]) ?>  
      </div>
   </div> 
  </div>

  
  <?= Html::submitInput('Incribirse', [
    'class'=>'btn btn-primary',
    'id'=>'btnInscription',
    'disabled'=>'true',
  ]) ?>
</div>
<?php 

  $form->end();

?>

<script>
let checkTerminos = document.getElementById('terminos');
let btnInscription = document.getElementById('btnInscription');

checkTerminos.addEventListener('click', () => {
checkTerminos.checked ? btnInscription.disabled = false : btnInscription.disabled = true;
});

btnInscription.addEventListener('click', () => {
alert('Felicitaciones. Se ha incripto al concurso');
});
</script>

</div>
<?php else: ?>
<div class="container">
  <h2>Concurso NO Encontrado</h2>
</div>
<?php endif; ?>
