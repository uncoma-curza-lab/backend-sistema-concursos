<?php

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

?>

<div class="card mr-2 mb-2" style="width: 15rem;">
    <div class="card-body">
        <h5 class="card-title">
            <?= $model->name; ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">
            Inscripciones abiertas <?= $model->enrollment_date_end; ?>
        </h6>
        <h6 class="card-subtitle mb-2 text-muted">
            Jornada <?= $model->workingDayType->name; ?>
        </h6>
        <p class="card-text">
            Asignatura: <?= $model->course->name; ?>
        </p>
        <?= Html::tag('a', 'Ver más', [
            'class' => 'btn btn-info btn-sm card-link',
            'href' => $moreUrl
        ]); ?>
    </div>
</div>
