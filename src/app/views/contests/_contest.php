<?php

use app\models\Activity;
use yii\helpers\Html;
use yii\helpers\Url;

$postulationUrl = Url::to([
    'postulations/contest-inscription',
    'slug' => $model->code
]);

$moreUrl = Url::to([
    'public-contest/details',
    'slug' => $model->code
]);

$today = date_create();
$enrollmentDateEnd = date_create($model->enrollment_date_end);
$enrollmentEnd = $enrollmentDateEnd > $today;
$incriptionText = $enrollmentEnd ? 'Inscripciones abiertas hasta ' : 'Inscripciones cerradas el '; 
$incriptionTextClass = $enrollmentEnd ? 'text-muted' : 'text-danger';

?>

<div class="card mr-2 mb-2" style="width: 15rem;">
    <div class="card-body">
        <h5 class="card-title">
            <?= $model->name; ?>
        </h5>
        <h6 class="card-subtitle mb-2 <?= $incriptionTextClass ?>">
            <?=$incriptionText . $model->enrollment_date_end; ?>
        </h6>
        <h6 class="card-subtitle mb-2 text-muted">
            Jornada <?= $model->workingDayType->name; ?>
        </h6>
        <?php if($model->hasCourseName()): ?>
            <p class="card-text">
                Asignatura: <?= $model->getCourseName(); ?>
            </p>
        <?php endif; ?>
        <?= Html::tag('a', 'Ver más', [
            'class' => 'btn btn-info btn-sm card-link',
            'href' => $moreUrl
        ]); ?>
    </div>
</div>
