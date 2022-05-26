<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backoffice', 'postulations_by_contest_title') . ' ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'Contest') . ' ' . $contest->name, 'url' => [ 'contest/view/'. $contest->code]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postulations-by-contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'uid',
                'label' => 'Documento',
                'value'  =>'person.uid'
            ],
            [
                'attribute' => 'personFullName',
                'label' => 'Nombre y Apellido',
                'value'  =>'person.fullName'
            ],
            [
                'attribute' => 'personEmail',
                'label' => 'Email',
                'value'  =>'person.contact_email'
            ],
            [
                'attribute' => 'statusDescription',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{approve} {reject} {viewProfile}',
                'buttons' => [
                    'approve' =>  function($url, $model, $key) {
                        if ($model->canApprove()) {
                            return Html::a(
                                '<span class="bi bi-check" aria-hidden="true"></span>',
                                ['postulation/approve', 'postulationId' => $model->id],
                                [
                                    'data' => 
                                    [
                                        'confirm' => Yii::t('app', 'Desea aprobar la postulación?'),
                                        'method' => 'post',
                                    ]
                                ]
                            );
                        }
                    },
                    'reject' =>  function($url, $model, $key) {
                        if ($model->canReject()) {
                            return Html::a(
                                '<span class="bi bi-x" aria-hidden="true"></span>',
                                ['postulation/reject', 'postulationId' => $model->id],
                                [
                                    'data' => 
                                    [
                                        'confirm' => Yii::t('app', 'Desea cancelar la postulación?'),
                                        'method' => 'post',
                                    ]
                                ]
                            );
                        }
                    },
                    'viewProfile' =>  function($url, $model, $key) {
                        if ($model->canReject()) {
                            return Html::a(
                                '<span class="bi bi-x" aria-hidden="true"></span>',
                                ['person/show', 'slug' => $model->person->uid],
                            );
                        }
                    },
                ],
            ],
        ],
    ]); ?>


</div>
