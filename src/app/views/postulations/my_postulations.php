<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'postulations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-postulations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contest.name',
            [
                'attribute' => 'contest.init_date'
            ],
            [
                'attribute' => 'contest.course_id',
                'value' => fn($model) => $model->contest->getCourseName()
            ],
            [
                'attribute' => 'contest.enrollment_date_end',
            ],
            [
                'attribute' => 'status',
                'value' => fn($model) => $model->getStatusDescription()
            ],
            [
                'attribute' => 'created_at',
                'value' => fn($model) => \Yii::$app->formatter->asDatetime($model->created_at, 'dd-MM-yyyy HH:mm')
            ],
            [
               'class' => 'yii\grid\ActionColumn',
               'template' => ' {download} {download-resolution} {files}',
               'buttons'=> [
                    'download' => function($url, $model, $key){
                        return Html::a(
                            '<span class="bi bi-file-earmark-arrow-down-fill" aria-hidden="true"></span>',
                            ['postulations/download-pdf', 'postulationId' => $model->id],
                            ['title' => 'Descargar Comprobante']
                        );
                    },
                    'download-resolution' => function($url, $model, $key){
                        if ($model->contest->isResolutionPublished()) {
                            return Html::a(
                                '<span class="bi bi-file-earmark-text-fill" aria-hidden="true"></span>',
                                ['postulations/download-resolution', 'slug' => $model->contest->code],
                                ['title' => 'Descargar Resolución']
                            );
                        }
                    },
                    'files' => function($url, $model, $key){
                        return Html::a(
                            '<span class="bi bi-folder-fill" aria-hidden="true"></span>',
                            ['postulations/postulation-files', 'postulationId' => $model->id],
                            ['title' => 'Cargar Archivos']
                        );
                    },
               ]
           ],
        ],
    ]); ?>


</div>

