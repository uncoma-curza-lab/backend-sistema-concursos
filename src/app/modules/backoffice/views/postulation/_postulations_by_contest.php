<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('backoffice', 'postulations_by_contest_title') . ' ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests') . ' ' . $contest->name, 'url' => [ 'contest/view/'. $contest->code]];
$this->params['breadcrumbs'][] = $this->title;
$columns = [
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
];
?>
<div class="postulations-by-contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
        'showColumnSelector' => false,
        'showConfirmAlert' => false,
        'exportConfig' => [
          ExportMenu::FORMAT_HTML => false,
          ExportMenu::FORMAT_EXCEL => false,
          ExportMenu::FORMAT_TEXT => false,
          ExportMenu::FORMAT_EXCEL_X => [
            'label' => 'Planilla de calculo',
          ],
        ],
        'dropdownOptions' => [
          'label' => 'Exportar',
        ]
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => array_merge(
            $columns, 
            [
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
                    $loggedUser = Yii::$app->user;
                    if (
                      Yii::$app->authManager->checkAccess($loggedUser->id, 'viewImplicatedPostulations', ['contestSlug' => $model->contest->code])
                      ||
                      Yii::$app->authManager->checkAccess($loggedUser->id, 'admin')
                      ||
                      Yii::$app->authManager->checkAccess($loggedUser->id, 'teach_departament')
                    ) {
                      return Html::a(
                        '<span class="bi bi-person-badge-fill" aria-hidden="true"></span>',
                        //TODO - create permision for delete slug
                        ['postulation/show', 'postulationId' => $model->id],
                      );
                    }
                  },
                ],
              ],
            ]
        ),
    ]); ?>


</div>
