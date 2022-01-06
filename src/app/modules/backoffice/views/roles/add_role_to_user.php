<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <h3> Añadir un rol al usuario <?= $user->person->getFullName()?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->dropDownList([
        'data' => $roles,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
