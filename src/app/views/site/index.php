<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = \Yii::$app->name;
$listView = ListView::begin([
    'dataProvider' => $dataProvider,
    'itemView' => '/contests/_contest',
    'itemOptions' => [
        'class' => '',
    ],
    'viewParams' => [
        'fullView' => true,
        'context' => 'public-contest',
    ],
    'options' => [
        'class' => '',
    ],
    'summary' => false,
    'pager' => [
        'firstPageLabel' => '<span class="bi bi-skip-backward-fill"></span>',
        'lastPageLabel' => '<span class="bi bi-skip-forward-fill"></span>',
        'prevPageLabel' => '<span class="bi bi-caret-left-fill"></span>',
        'nextPageLabel' => '<span class="bi bi-caret-right-fill"></span>',
    ],
]);
$showAlert = false;
$alertText = '';
if(\Yii::$app->user->isGuest){
    $alertText = 'Debe ' . Html::tag('a', 'Registrarse', ['href' => Url::to('/signup')]) . 
        ' o ' . Html::tag('a', 'Iniciar Sesión', ['href' => Url::to('/login')]) . ' para incribirse a un concurso';
    $showAlert = true;
}elseif(!\Yii::$app->user->identity->isValid()){
    $alertText = 'Debe completar todos sus datos personales para incirbirse a un concurso: ' . Html::tag('a', 'Completar Datos', [
            'href' => Url::to('/user/profile'),
        ]);
    $showAlert = true;
}

?>
<div class="site-index">
    <?php 
    if($showAlert):
    ?>
    <div class="alert alert-warning" role="alert">
        <?= $alertText ?>
    </div>
    <?php 
       endif;
    ?>
    

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= \Yii::t('app', 'welcome'); ?></h1>
        <p class="mt-5">

        <div class="public-contest container">

            <div class ="d-flex flex-row flex-wrap justify-content-center">
                <?= $listView->renderItems(); ?>
            </div>
            <div class="mt-5">
                <?= $listView->renderPager() ?>
            </div>
        </div>
        <?= Html::tag('a', \Yii::t('app', 'view_contests'), [
            'class' => 'btn btn-lg btn-info',
            'href' => Url::to('/contests'),
        ]); ?>
        </p>
    </div>

</div>
