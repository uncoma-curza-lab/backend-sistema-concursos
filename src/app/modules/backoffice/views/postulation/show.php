<?php

use app\widgets\files\FilesGrid;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<h3>Perfil del postulante</h3>
<div class="row justify-content-end">
  <?= Html::a('Volver', Url::to(['postulation/contest', 'slug' => $postulation->contest->code]), ['class'=>'btn btn-info float-right']) ?>
</div>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
    <button class="nav-link" id="nav-documents-tab" data-toggle="tab" data-target="#nav-documents" type="button" role="tab" aria-controls="nav-documents" aria-selected="false">Documents</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="container mt-4">
            <?= $this->render('/person/read_only_profile', ['profile' => $profile]) ?>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-documents" role="tabpanel" aria-labelledby="nav-documents-tab">
        <div class="container mt-4">
            <?= FilesGrid::widget([
                'dataProvider' => $files,
                'options' => [
                    'search' => false
                ],
                'actionButtons' => [
                    'view' => true,
                    'download' => true,
                    'validation' => $canValidate ? ['form' => $validationForm] : $canValidate,
                ]
                ]) ?>
        </div>
    </div>
</div>
<div class="row justify-content-end">
  <?= Html::a('Volver', Url::to(['postulation/contest', 'slug' => $postulation->contest->code]), ['class'=>'btn btn-info float-right']) ?>
</div>


