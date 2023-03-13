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

    <h1><?= Html::encode($this->title) ?></h1>

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
        endif;
?>
        <?php if ($model->contestStatus->is(ContestStatus::DRAFT)) : ?>
        <?= Html::a(Yii::t('backoffice', 'Publicar concurso'), ['publish-contest', 'slug' => $model->code], [
            'class' => 'btn btn-info',
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
        ]) ?>
        <?= Html::a(
                Yii::t('backoffice', 'attach_file'),
                ['/backoffice/contest-attached-files/attach-file', 'slug' => $model->code ],
                    [
                        'class' => 'btn btn-success',
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'code',
            [
                'attribute' => 'course_id',
                'value' => $model->getCourseName(),
            ],
            [
              'attribute' => 'contest_status_id',
              'value' => $model->contestStatus ?  ContestStatus::getTranslation($model->contestStatus->code) : '',
            ],
            'qty',
            [
                'attribute' => 'init_date',
                'type' => 'date',
            ],
            [
                'attribute' => 'end_date',
                'type' => 'date',
            ],
            [
                'attribute' => 'enrollment_date_end',
                'type' => 'date',
            ],
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
        <div class="card">
            <div class="card-body">
            <h5 class="card-title"><?= Yii::t('backoffice', 'attached_files') ?></h5>
              <div class="list-group">
                  <?php 
                  foreach ($model->attachedFiles as $file): 
                      //TODO - Delete method
                  ?>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col">
                                  <div class="d-flex w-100 justify-content-start">
                                    <i class="bi bi-file-earmark-text-fill" aria-hidden="true"></i>
                                    <?= $file->documentType->name ?> - 
                                    <?= $file->name ?>
            
                                  </div>
                               </div>
                               <div class="col-md-auto">
                                  <a class="btn btn-success" href="<?= url::to(['@web/' . $file->path]) ?>" target="_blank" title="Ver"><i class="bi bi-eye"></i></a>
                                  <a class="btn btn-danger" href="<?= url::to(['@web/' . $file->path]) ?>" title="Borrar"><i class="bi bi-trash"></i></a>
                               </div>
                            </div>
                        </div>
                  <?php 
                  endforeach;
                  ?>
              </div>
            </div>
        </div>
    </div>
</div>
