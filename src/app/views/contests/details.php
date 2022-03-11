<?php

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
          <td name="asignatura"><?= $contest->course->name ?></td>
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
  <a href="<?= Url::toRoute(['postulations/contest-inscription', 'slug' => $contest->code ]) ?>" 
  class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Insribirse </a>
  <button type="button" id="btnIncripcion" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVerificacion">
  Launch demo modal
</button>
</div>
<!-- Modal -->
<div class="modal fade" id="modalVerificacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Declaración Jurada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <input type='checkbox' id='art22'>Artículo 22 (Res. CD CURZA N 112/1991): La presentación de la solicitud de inscripción importa, por parte del postulante, el conocimiento y la aceptación de las condiciones fijadas en este reglamento

        </div>
        <div>
          <input type='checkbox' id='confirm_data'>DECLARO BAJO JURAMENTO NO ESTAR COMPROMETIDO EN LAS CAUSALES DE INHABILITACIÓN PARA EL DESEMPEÑO DE CARGOS PÚBLICOS
        </div>
                    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Canelar</button>
        <button type="button" id='btnPostularse' class="btn btn-primary">Postularse</button>
      </div>
    </div>
  </div>
</div>
<script>

  document.getElementById('btnPostularse').addEventListener('click', ()=>{
    let art22 = document.getElementById('art22').checked
    let confirm_data = document.getElementById('confirm_data').checked
    console.log(art22)
    if(!art22 || !confirm_data){
alert('Debe Completar la declaración Jurada')
}
  })

  </script> 
<?php else: ?>
<div class="container">
  <h2>Concurso NO Encontrado</h2>
</div>
<?php endif; ?>

