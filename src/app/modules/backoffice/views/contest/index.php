<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backoffice', 'contests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'create_contest_button'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'code',
            'qty',
            [
                'attribute' => 'course_id',
                'value' => fn($data) => $data->getCourse()->name ?? 'unavailable'
            ],
            'init_date:date',
            'enrollment_date_end:date',
            'end_date:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {update} {delete} {postulations} {juries} {set-status}',
                'buttons' => [
                    'postulations' =>  function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-person-lines-fill" aria-hidden="true"></span>',
                            Url::to(['postulation/contest', 'slug' => $model->code])
                        );
                    },
                    'juries' => function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-people-fill" aria-hidden="true"></span>',
                            Url::to(['juries/contest', 'slug' => $model->code])
                        );
                    },
                    'set-status' => function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-ui-radios" aria-hidden="true"></span>',
                            Url::to(['contest/set-status', 'slug' => $model->code])
                        );
                    }
                ],
                'urlCreator' => function($action, $model, $key, $index) {
                    $entity = 'contest';
                    $routePrefix = '/backoffice/' . $entity;
                    if($action === 'view') {
                        return Url::toRoute([
                            $routePrefix . '/view',
                            'slug' => '' . $model->code
                        ]);
                    }

                    if($action === 'update') {
                            return Url::toRoute([
                            $routePrefix . '/update',
                            'slug' => '' . $model->code
                        ]);
                    }

                    if($action === 'delete') {
                        return Url::toRoute([
                            $routePrefix . '/delete',
                            'slug' => '' . $model->code
                        ]);
                    }
                },
            ],
        ],
    ]); ?>


</div>
