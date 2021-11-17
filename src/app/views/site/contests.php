<?php

use yii\helpers\Url;

?>
<div class="contaner">
<h2>Concurso - <?= $data->name ?></h2>

<p>
    El Centro Universitario Regional Zona Atlántica de la Universidad Nacional 
    del Comahue comunica que se llama a concurso de antecedentes para cubrir 
    cargos docentes para el año académico 2021.
</p>

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
      <td name="area"><?= $data->area_id  ?></td>
      <td name="orientacion"><?= $data->orientation_id ?></td>
      <td name="asignatura"><?= $data->course_id ?></td>
      <td name="cargos"><?= $data->qty ?></td>
      <td name="categoria"><?= $data->category_type_id ?></td>
      <td name="dedicacion"><?= $data->working_day_type_id ?></td>      
    </tr>  
  </tbody>
</table>

<h3>Incripciones:</h3>
<ul>
    <?php
        $date = date_create($data->enrollment_date_end);        
    ?>
    <li>Hasta el:  <?= date_format($date, "d-m-Y")?></li>
</ul>


<a href="<?= Url::toRoute('site/contact') ?>" 
class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Insribirse </a>

</div>
