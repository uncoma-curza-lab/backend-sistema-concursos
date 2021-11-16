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
        <a class="btn btn-primary btn-sm card-link">
            Inscribirse
        </a>
        <a class="card-link">
            Ver más
        </a>
    </div>
</div>
