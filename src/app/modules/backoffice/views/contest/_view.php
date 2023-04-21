<?php

use app\models\ContestStatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contests-view">

    <p>
<?php 
        if (
            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
            ||
            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
            ):
?>
        <?= Html::a(Yii::t('backoffice', 'Actualizar'), ['update', 'slug' => $model->code], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backoffice', 'Eliminar'), ['delete', 'slug' => $model->code], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backoffice', 'Está seguro de que desea eliminar el concurso?'),
                'method' => 'post',
            ],
        ]);
?>
        <?php if ($model->contestStatus->is(ContestStatus::DRAFT)) : ?>
        <?= Html::a(Yii::t('backoffice', 'Publicar concurso'), ['publish-contest', 'slug' => $model->code], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => Yii::t('backoffice', 'Está seguro de que desea publciar el concurso?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
        <?= Html::a(
                $model->highlighted ? Yii::t('backoffice', 'unset_highlight') : Yii::t('backoffice', 'set_highlight'),
                ['change-highlight-status', 'slug' => $model->code],
                    [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'method' => 'post',
                    ],
                ]);
        endif;
    ?>
        <?= Html::a(
                'Ver Publicación',
                ['/public-contest/details/' . $model->code],
                    [
                        'class' => 'btn btn-info',
                        'target' => '_blank',
                ]) ?>

    </p>
<div class="card m-2">
  <div class="card-header">
    <div class="d-flex justify-content-between">
    <h3>
        <?= $model->name ?>
    </h3>
    <div>
        <h4>
            <span class="badge badge-primary">
                <?= $model->contestStatus ?  ContestStatus::getTranslation($model->contestStatus->code) : '' ?>
            </span>
        </h4>
    </div>
    </div>
      </div>
      <div class="card-body">
      <h5 class="card-title"><?= $model->getCourseName() ?></h5>
      <p class="card-text">Vacantes: <?= $model->qty ?></p>
      <p class="card-text">Las inscripciones inician el <?= $model->init_date ?> y cierran el <?= $model->enrollment_date_end ?></p>
      <p class="card-text">El concuros cierra el <?= $model->end_date ?></p>

        <a class="btn btn-info btn-block" data-toggle="collapse" href="#more_info" role="button" aria-expanded="false" aria-controls="more_info">Más Información</a>
            <div id="more_info" class="collapse">
                <div class="card mt-3 p-3">
    
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'code',
                        [
                            'attribute' => 'remuneration_type_id',
                            'value' => $model->remunerationType->name
                        ],
                        [
                            'attribute' => 'working_day_type_id',
                            'value' => $model->workingDayType->name
                        ],
                        [
                            'attribute' => 'category_type_id',
                            'value' => $model->categoryType->name
                        ],
                        [
                            'attribute' => 'area_id',
                            'value' => $model->getAreaName()
                        ],
                        [
                            'attribute' => 'orientation_id',
                            'value' => $model->getOrientationName()
                        ],
                    ],
                ]) 
            ?>
            
            </div>
            </div>
      </div>
    </div>
    <div class="m-2">
        <?= $this->render('_attached_files', ['attachedFiles' => $model->attachedFiles, 'contest' => $model]) ?>
    </div>
</div>
