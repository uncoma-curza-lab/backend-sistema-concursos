<?php

use app\models\ContestStatus;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$loggedUser = Yii::$app->user;
$roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));

$this->title = Yii::t('backoffice', 'contests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (in_array('admin', $roles) || in_array('teach_departament', $roles)): ?>
            <?= Html::a(Yii::t('backoffice', 'create_contest_button'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'container-fluid',
        ],
        'tableOptions' => [
            'class' => 'table table-responsive table-bordered table-striped',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'qty',
                'contentOptions' => [
                    'style' => 'width: 5%;',
                ] 
            ],
            [
                'attribute' => 'course_id',
                'value' => fn($data) => $data->getCourseName(),
            ],
            [
                'attribute' => 'contest_status_id',
                'value' => fn($data) =>  $data->contestStatus->getStatusName() ?? 'unavailable',
            ],
            'init_date:date',
            'enrollment_date_end:date',
            'end_date:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {update} {delete} {postulations} {files} {juries} {set-status} {upload-resolution} {download-resolution} {publish-resolution}',
                'buttons' => [
                    'postulations' =>  function($url, $model, $key) {
                        if (
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {
                            //Notify when have postulations on pending status
                            $notify = $model->hasPendingPostulations() ? 'style="color: #E58B16;"' : '';
                            return Html::a(
                                '<span class="bi bi-person-lines-fill" ' . $notify . ' aria-hidden="true"></span>',
                                Url::to(['postulation/contest', 'slug' => $model->code]),
                                [
                                    'title' => 'Postulaciones'
                                ]
                            );
                        }
                    },
                    'files' => function($url, $model, $key){
                        if (
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {
                            return Html::a(
                                '<span class="bi bi-folder-fill" aria-hidden="true"></span>',
                                ['contest/contest-files', 'contestId' => $model->id],
                                ['title' => 'Archivos']
                            );
                        }
                    },
                    'juries' => function($url, $model, $key) {
                        if (
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {
                            return Html::a(
                                '<span class="bi bi-people-fill" aria-hidden="true"></span>',
                                Url::to(['juries/contest', 'slug' => $model->code]),
                                [
                                    'title' => 'Jurados'
                                ]
                            );
                        }
                    },
                    'set-status' => function($url, $model, $key) {
                        if (
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {
                            return Html::a(
                                '<span class="bi bi-ui-radios" aria-hidden="true"></span>',
                                Url::to(['contest/set-status', 'slug' => $model->code]),
                                [
                                    'title' => 'Cambiar estado'
                                ]
                            );
                        }
                    },
                    'upload-resolution' => function($url, $model, $key) {
                        
                        if (
                            $model->canUploadResolution()
                            &&
                            (\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $model->code]))
                        ) {
                            return Html::a(
                                '<span class="bi bi-file-earmark-arrow-up" aria-hidden="true"></span>',
                                Url::to(['contest/upload-resolution', 'slug' => $model->code]),
                                [
                                    'title' => 'Subir dictamen'
                                ]
                            );
                        }
                    },
                    'download-resolution' => function($url, $model, $key) {
                        if ($model->isDownloadeableResolution()) {
                            return Html::a(
                                '<span class="bi bi-download" aria-hidden="true"></span>',
                                Url::to(['contest/download-resolution', 'slug' => $model->code]),
                                [
                                    'title' => 'Descargar dictamen'
                                ]
                            );
                        }
                    },
                    'publish-resolution' => function($url, $model, $key) {
                        if ($model->isDownloadeableResolution() 
                            &&
                            !$model->isResolutionPublished()
                            &&
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {
                            return Html::a(
                                '<span class="bi bi-file-earmark-check" aria-hidden="true"></span>',
                                ['contest/publish-resolution', 'slug' => $model->code],
                                [
                                    'data' => 
                                    [
                                        'confirm' => Yii::t('app', 'Desea publicar el dictamen?'),
                                        'method' => 'post',
                                    ],
                                    'title' => 'Publicar dictamen',
                                ]
                            );
                        }
                    },
                    'delete' => function($url, $model, $key) {
                        if (
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                        ) {

                            return Html::a(
                                '<span class="bi bi-trash" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/contest/delete',
                                    'slug' => $model->code,
                                ]),
                                [
                                    'data' => 
                                    [
                                        'confirm' => Yii::t('app', 'Desea publicar el dictamen?'),
                                        'method' => 'post',
                                    ],
                                    'title' => 'Eliminar concurso',
                                ]
                            );
                        }
                    },
                    'update' => function($url, $model, $key) {
                        $loggedUser = Yii::$app->user;
                        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
                        if (in_array('admin', $roles) || in_array('teach_departament', $roles)) {

                            return Html::a(
                                '<span class="bi bi-pencil" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/contest/update',
                                    'slug' => '' . $model->code
                                ]),
                                [
                                    'title' => 'Actualizar concurso',
                                ]
                            );
                        }
                    },
                    'view' => function($url, $model, $key) {
                        $loggedUser = Yii::$app->user;
                        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
                        if (in_array('admin', $roles) || in_array('teach_departament', $roles)) {

                            return Html::a(
                                '<span class="bi bi-eye-fill" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/contest/view',
                                    'slug' => '' . $model->code
                                ]),
                                [
                                    'title' => 'Ver Concurso',
                                ]
                            );
                        }
                    }
                ],
                'urlCreator' => function($action, $model, $key, $index) {
                    if($action === 'view') {
                        return Url::toRoute([
                            '/backoffice/contest/view',
                            'slug' => '' . $model->code
                        ]);
                    }
                },
            ],
        ],
    ]); ?>


</div>
