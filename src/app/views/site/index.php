<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= \Yii::t('app', 'welcome'); ?></h1>
        <p class="mt-5">
        <?= Html::tag('a', \Yii::t('app', 'view_contests'), [
            'class' => 'btn btn-lg btn-info',
            'href' => Url::to('/contests'),
        ]); ?>
        </p>
    </div>

</div>
