<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<div class="contests-form">

<h3>Cambiar estado del concurso: <i> <?= $model->name ?></i></h3>
<?php

$form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'contest_status_id')->widget(Select2::class, [
        'data' => $statuses,
        'options' => ['placeholder' => 'Seleccione un estado...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Nuevo estado') ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'save_button'), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', ['index'], ['class'=>'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
