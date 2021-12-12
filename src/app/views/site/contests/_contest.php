<?php

use yii\helpers\Html;
use yii\helpers\Url;

$postulationUrl = Url::to([
    'postulate',
    'slug' => $model->code
]);

$moreUrl = Url::to([
    'details',
    'slug' => $model->code
]);

?>

<div class="card" style="width: 15rem;">
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
            <?= $model->description; ?>
        </p>
        <?= Html::tag('a', 'Inscribirse', [
            'class' => 'btn btn-primary btn-sm card-link',
            'href' => $postulationUrl
        ]); ?>
        <?= Html::tag('a', 'Ver más', [
            'class' => 'card-link',
            'href' => $moreUrl
        ]); ?>
    </div>
</div>
