<?php

use app\models\ContestStatus;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$loggedUser = Yii::$app->user;
$roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));

$this->title = Yii::t('backoffice', 'contests');
$this->params['breadcrumbs'][] = $this->title;

$adminRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin');
$teacher_departmentRol = \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament');

?>
<div class="contests-index">
    <?php
      Yii::$app->session->getAllFlashes();
    ?>
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
            ['class' => 'kartik\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'course_id',
                'value' => fn($data) => $data->getCourseName(),
            ],
            [
                'attribute' => 'contest_status_id',
                'value' => fn($data) =>  $data->contestStatus->getStatusName() ?? 'unavailable',
                'filter'    => [
                    1 => \Yii::t('models/contest-status', 'draft'),
                    2 => \Yii::t('models/contest-status', 'published'),
                    3 => \Yii::t('models/contest-status', 'in_process'),
                    4 => \Yii::t('models/contest-status', 'finished')
                ]
            ],
            'init_date:date',
            'enrollment_date_end:date',
            [
                'class' => '\kartik\grid\BooleanColumn',
                'attribute'=>'highlighted',
                'value' => fn($data) => $data->isHighlighted(),
                'falseIcon' => '',
                'trueIcon' => '<span class="bi bi-exclamation-circle-fill text-success"></span>',
                'vAlign'=>'middle',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'dropdownMenu' => ['class' => 'dropdown-menu p-3', 'style' => 'heigth: 100px;'],
                'dropdownButton' => [
                    'label' => '<span class="bi bi-pencil-square"></span>', 
                    'title' => 'Acctiones',
                ],
                'template' => ' {view} {update} {delete} {postulations} {files} {juries} {set-status} {upload-resolution} {download-resolution} {publish-resolution}',
                'buttons' => [
                    'postulations' =>  function($url, $model, $key) use ($adminRol, $teacher_departmentRol){
                        if (
                            $adminRol
                            ||
                            $teacher_departmentRol
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                        ) {
                            //Notify when have postulations on pending status
                            $notify = $model->hasPendingPostulations() ? 'style="color: #E58B16;"' : '';
                            return Html::a(
                                '<span class="bi bi-person-lines-fill" ' . $notify . ' aria-hidden="true"></span>',
                                Url::to(['postulation/contest', 'slug' => $model->code]),
                                [
                                    'title' => 'Postulaciones',
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'files' => function($url, $model, $key) use ($adminRol, $teacher_departmentRol){
                        if (
                            $adminRol
                            ||
                            $teacher_departmentRol
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                        ) {
                            return Html::a(
                                '<span class="bi bi-folder-fill" aria-hidden="true"></span>',
                                ['contest/contest-files', 'contestId' => $model->id],
                                ['title' => 'Archivos', 'class' => 'p-2']
                            );
                        }
                    },
                    'juries' => function($url, $model, $key) use ($adminRol, $teacher_departmentRol){
                        if (
                            $adminRol
                            ||
                            $teacher_departmentRol
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                        ) {
                            return Html::a(
                                '<span class="bi bi-people-fill" aria-hidden="true"></span>',
                                Url::to(['juries/contest', 'slug' => $model->code]),
                                [
                                    'title' => 'Jurados',
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'set-status' => function($url, $model, $key) use ($adminRol, $teacher_departmentRol){
                        if (
                            $adminRol
                        ) {
                            return Html::a(
                                '<span class="bi bi-ui-radios" aria-hidden="true"></span>',
                                Url::to(['contest/set-status', 'slug' => $model->code]),
                                [
                                    'title' => 'Cambiar estado',
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'upload-resolution' => function($url, $model, $key) use ($adminRol, $teacher_departmentRol){
                        
                        if (
                            $model->canUploadResolution()
                            &&
                            ($teacher_departmentRol
                            ||
                            $adminRol
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'uploadResolution', ['contestSlug' => $model->code]))
                        ) {
                            return Html::a(
                                '<span class="bi bi-file-earmark-arrow-up" aria-hidden="true"></span>',
                                Url::to(['contest-attached-files/attach-file', 'slug' => $model->code]),
                                [
                                    'title' => 'Subir dictamen',
                                    'class' => 'p-2',
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
                                    'title' => 'Descargar dictamen',
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'publish-resolution' => function($url, $model, $key) use ($adminRol, $teacher_departmentRol) {
                        if ($model->isDownloadeableResolution() 
                            &&
                            !$model->isResolutionPublished()
                            &&
                            ($teacher_departmentRol
                            ||
                            $adminRol)
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
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'delete' => function($url, $model, $key) use ($teacher_departmentRol, $adminRol){
                        if (
                            $teacher_departmentRol
                            ||
                            $adminRol
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
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'update' => function($url, $model, $key) use ($teacher_departmentRol, $adminRol){
                        if (
                            $teacher_departmentRol
                            ||
                            $adminRol
                        ) {

                            return Html::a(
                                '<span class="bi bi-pencil" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/contest/update',
                                    'slug' => '' . $model->code
                                ]),
                                [
                                    'title' => 'Actualizar concurso',
                                    'class' => 'p-2',
                                ]
                            );
                        }
                    },
                    'view' => function($url, $model, $key) use ($teacher_departmentRol, $adminRol){
                        if (
                            $teacher_departmentRol
                            ||
                            $adminRol
                            ||
                            \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'viewImplicatedPostulations', ['contestSlug' => $model->code])
                        ) {

                            return Html::a(
                                '<span class="bi bi-eye-fill" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/contest/view',
                                    'slug' => '' . $model->code
                                ]),
                                [
                                    'title' => 'Ver Concurso',
                                    'class' => 'p-2',
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
