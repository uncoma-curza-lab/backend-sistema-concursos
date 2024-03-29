<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProject */

$this->title = ucfirst(Yii::t('backoffice', 'update')) . " " . Yii::t('models/institutional-projects', 'Institutional Project'). " " . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models/institutional-projects', 'Institutional Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ucfirst(Yii::t('backoffice', 'update'));
?>
<div class="institutional-project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
