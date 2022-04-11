<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backoffice', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backoffice', 'Create Users'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'uid',
            'person.fullname',
            [
                'attribute' => 'roles',
                'format' => 'html',
                'value' => function($user) {
                    $roles = '';
                    foreach(Yii::$app->authManager->getRolesByUser($user->id) as $role) {
                        $roles .= $role->name . '<br>';
                    }
                    return $roles;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {update} {delete} {edit-profile} {add-role}',
                'buttons' => [
                    'edit-profile' =>  function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-person-lines-fill" aria-hidden="true"></span>',
                            Url::to(['user/edit-profile', 'id' => $model->id])
                        );
                    },
                    'add-role' =>  function($url, $model, $key) {
                        return Html::a(
                            '<span class="bi bi-key-fill" aria-hidden="true"></span>',
                            Url::to(['roles/replace-to-user', 'userId' => $model->id])
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
