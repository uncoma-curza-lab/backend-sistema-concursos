<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

use kartik\depdrop\DepDrop;

?>

<div class="contests-form">

<?php

$form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'contest_status_id')->widget(Select2::class, [
        'data' => $statuses,
        'options' => ['placeholder' => 'Seleccione un estado...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backoffice', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
