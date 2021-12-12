<?php

use yii\widgets\ListView;

$this->title = 'Concursos publicados';
//$this->params['breadcrumbs'][] = $this->title;
$listView = ListView::begin([
    'dataProvider' => $dataProvider,
    'itemView' => '_contest',
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

<div class="public-contest container">
    <h2> <?= Yii::t('models/contest', 'plural'); ?></h2>

    <div class ="d-flex flex-row flex-wrap justify-content-start ">
        <?= $listView->renderItems(); ?>
    </div>
    <div class="mt-5">
        <?= $listView->renderPager() ?>
    </div>
</div>
