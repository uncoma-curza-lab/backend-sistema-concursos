<?php

use app\widgets\files\FilesGrid;
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
                '<i class="bi bi-file-earmark-arrow-up"></i> ' .
                Yii::t('models/personal-files', 'upload_new_personal_file'),
                ['upload-file'],
                ['class' => 'btn btn-primary']
            ) ?>
        </p>
        <?= 
            FilesGrid::widget([
                'dataProvider' => $files,
                'actionButtons' => [
                    'view' => true,
                    'download' => true,
                    'delete' => fn($file) => !$hasActiveContest || !$file->isValid(),
                ]
            ]) 
        ?>

    </div>
</div>

