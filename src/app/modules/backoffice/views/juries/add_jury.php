<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orientations */
/* @var $form yii\widgets\ActiveForm */
var_dump(Yii::$app->request());
die();
?>

<div class="orientations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->dropDownList($juryUsers, []) ?>

    <?= $form->field($model, 'isPresident')->checkbox([]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'save_button'), ['class' => 'btn btn-success']) ?>
        <?= Html::tag('a', \Yii::t('app', 'cancel_button'), [
            'class' => 'btn btn-lg btn-info',
            'href' => Url::to('/juries/contest/', []),
        ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
