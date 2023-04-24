<?php

use app\models\InstitutionalProject;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models/institutional-projects', 'Institutional Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institutional-project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(ucfirst(Yii::t('backoffice', 'create')) . " " . $this->title = Yii::t('models/institutional-projects', 'Institutional Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, InstitutionalProject $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
