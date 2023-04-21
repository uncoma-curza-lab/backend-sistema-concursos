<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionalProject */

$this->title = ucfirst(Yii::t('backoffice', 'create')) . " " . $this->title = Yii::t('models/institutional-projects', 'Institutional Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models/institutional-projects', 'Institutional Project'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institutional-project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
