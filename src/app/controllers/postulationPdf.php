
<body>
<img src="./LOGOUNCO.png" alt="LOGO UNCO">
    <h1>Comprobante de Postulación a <?= $contest->name ?></h1>
    <p>Ud esta incripto al cargo de <?= $contest->course->name ?> con estado <?= $postulation->getStatusDescription() ?></p>
    
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

    <ul>
        <li>Regrisrado el: <?= $postulation->changeDateFormat($postulation->created_at) ?></li>
        <li>Finalización de la incripciones: <?= $contest->enrollment_date_end ?></li>
</ul>
</body>
</html>