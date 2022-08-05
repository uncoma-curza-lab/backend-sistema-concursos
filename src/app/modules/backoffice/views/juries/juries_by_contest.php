<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('backoffice', 'juries_by_contest_title') . ' ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests') . ' ' . $contest->name, 'url' => [ 'contest/view/'. $contest->code]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="juries-by-contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php 
            if (
                \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')
                ||
                \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'teach_departament')
            ) :
        ?>
        <?= Html::a('<i class="bi bi-person-plus-fill"></i> ' . Yii::t('backoffice', 'add_jury_to_contest_button'), ['add-jury', 'slug' => $contest->code], ['class' => 'btn btn-success']) ?>
<?php 
            endif;
?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'personFullName',
                'label' => 'Nombre y Apellido',
                'value'  =>'user.person.fullname'
            ],
            [
                'attribute' => 'personEmail',
                'label' => 'Email',
                'value'  =>'user.person.contact_email'
            ],
            [
                'attribute' => 'is_president',
                'label' => 'Presidente',
                'value' => fn($value) => $value->is_president ? 'Si' :'No',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        $loggedUser = Yii::$app->user;
                        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
                        if (in_array('admin', $roles) || in_array('teach_departament', $roles)) {

                            return Html::a(
                                '<span class="bi bi-person-x-fill" aria-hidden="true"></span>',
                                Url::toRoute([
                                    '/backoffice/juries/delete',
                                    'contest' => $model->contest->code,
                                    'user' => '' . $model->user_id
                                ]),
                                [
                                    'title' => 'Eliminar Jurado',
                                    'data' => 
                                    [
                                        'confirm' => Yii::t('app', '¿Desea eliminar este Jurado?'),
                                        'method' => 'post',
                                    ]
                                ]
                            );
                        }
                    }
                ]
            ],
        ],
    ]); ?>


</div>
