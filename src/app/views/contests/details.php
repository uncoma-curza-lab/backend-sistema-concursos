<?php

use yii\helpers\Url;

if ($data!=null):
?>
<div class="contaner">
  <h2>Concurso - <?= $data->name ?></h2>
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
  <div class="container">
    <dl class="row">
      <dt class="col-sm-3">Incripciones</dt>
      <dd class="col-sm-9">
        <ul>
            <?php
                $initDate = date_create($data->init_date);
                $enrollmentDate = date_create($data->enrollment_date_end);        
            ?>
            <li>Se recibirán incripciones desde el <?= date_format($initDate, "d-m-Y")?> 
            hasta el  <?= date_format($enrollmentDate, "d-m-Y")?></li>
        </ul>
      </dd>
      
      <dt class="col-sm-3">Requisitos</dt>
      <dd class="col-sm-9">
      <ul>
          <li>            
            Titulo Universitario
          </li>
          <li >            
            Curriculum Vitae con las certificaciones correspondientes
          </li>
          <li>            
            Copia de DNI
          </li>
          <li>            
            Residir o estar dispuesto a residir en la localidad de Viedma o aledaños
          </li>
          <li>            
            "Propuesta de programa de la asignatura"
          </li>
        </ul>
      </dd>
      
      <dt class="col-sm-3">Entrevista</dt>
      <dd class="col-sm-9">
        <p> Fecha a Determinar</p>
      </dd>
      
      <dt class="col-sm-3">Informes</dt>
      <dd class="col-sm-9">
        <p>
          Para Mayor información dirijirse a:
        </p>
        <ul>
          <li>
            Secretaría Academica: <a href="mailto:secretaria.academica@curza.uncoma.edu.ar">
            secretaria.academica@curza.uncoma.edu.ar</a>
          </li>
          <li>
            Departamento Docente: <a href="mailto:departamento.docente@curza.uncoma.edu.ar">
            departamento.docente@curza.uncoma.edu.ar</a>
          </li>
          <li>
            Coordinación Exactas: <a href="mailto:coordinacion.exactas@curza.uncoma.edu.ar">
            coordinacion.exactas@curza.uncoma.edu.ar</a>
          </li>
        </ul>
      </dd>
    </dl>

  </div>
  <br>
  <a href="<?= Url::toRoute('site/contact') ?>" 
  class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Insribirse </a>

</div>
<?php else: ?>
<div class="container">
  <h2>Concurso NO Encontrado</h2>
</div>
<?php endif; ?>
