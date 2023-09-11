<?php

use yii\helpers\Html;

$this->title = Yii::t('models/personal-files', 'files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-files-index card">
    <div class="card-body">
        <h1 class="card-title">
           <?= Html::encode($this->title) ?>
        </h1>
    
        <p>
            <?= Html::a(
                Yii::t('models/personal-files', 'upload_new_file'),
                ['upload-file'],
                ['class' => 'btn btn-primary']
            ) ?>
        </p>
        <?= $this->render('_files_list', ['files' => $files]) ?>
    </div>
</div>

