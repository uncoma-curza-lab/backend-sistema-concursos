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
$listViewHighlighteds = ListView::begin([
    'dataProvider' => $dataProviderHighlighteds,
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

?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= \Yii::t('app', 'welcome'); ?></h1>
        <p class="mt-5">


        <div class="public-contest container">

            <h2>Concursos</h2>
            <div class ="d-flex flex-row flex-wrap justify-content-center">
                <?= $listView->renderItems(); ?>
            </div>
            <div class="mt-5">
                <?= $listView->renderPager() ?>
            </div>
        </div>

        <div class="public-contest-highlight container bg-secondary p-3 m-3">
            <h2>Publicacion de Jurados</h2>
            <div class ="d-flex flex-row flex-wrap justify-content-center">
                <?= $listViewHighlighteds->renderItems(); ?>
            </div>
            <div class="mt-5">
                <?= $listViewHighlighteds->renderPager() ?>
            </div>

        </div>

        <?= Html::tag('a', \Yii::t('app', 'view_contests'), [
            'class' => 'btn btn-lg btn-info',
            'href' => Url::to('/contests'),
        ]); ?>
        </p>
    </div>

</div>
