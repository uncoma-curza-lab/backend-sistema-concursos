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
                'attribute' => 'contest.enrollment_date_end',
            ],
            [
                'attribute' => 'status',
                'value' => fn($model) => $model->getStatusDescription()
            ],
                'created_at',
            [
               'class' => 'yii\grid\ActionColumn',
               'template' => ' {download} {download-resolution} {files}',
               'buttons'=> [
                    'download' => function($url, $model, $key){
                        return Html::a(
                            '<span class="bi bi-file-earmark-arrow-down-fill" aria-hidden="true"></span>',
                            ['postulations/download-pdf', 'postulationId' => $model->id]
                        );
                    },
                    'download-resolution' => function($url, $model, $key){
                        if ($model->contest->isResolutionPublished()) {
                            return Html::a(
                                '<span class="bi bi-file-earmark-text-fill" aria-hidden="true"></span>',
                                ['postulations/download-resolution', 'slug' => $model->contest->code]
                            );
                        }
                    },
                    'files' => function($url, $model, $key){
                        return Html::a(
                            '<span class="bi bi-folder-fill" aria-hidden="true"></span>',
                            ['postulations/postulation-files', 'postulationId' => $model->id]
                        );
                    },
               ]
           ],
        ],
    ]); ?>


</div>
<style>
span{
    font-size: 1.7em;
}
</style>
