<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backoffice', 'Contests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'Create Contests'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            'qty',
            'init_date',
            //'end_date',
            //'enrollment_date_end',
            //'description:ntext',
            //'remuneration_type_id',
            //'working_day_type_id',
            //'course_id',
            //'category_type_id',
            //'area_id',
            //'orientation_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {update} {delete} {postulations}',
                'buttons' => [
                    'postulations' =>  function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-people-fill" aria-hidden="true"></span>',
                            Url::to(['postulation/contest', 'slug' => $model->code])
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
