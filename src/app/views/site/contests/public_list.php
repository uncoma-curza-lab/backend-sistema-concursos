<?php

use yii\widgets\ListView;

$this->title = 'Concursos publicados';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="public-contest">
    <h2> <?= Yii::t('models/contest', 'plural'); ?></h2>

    <?=
      ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_contest',
        'viewParams' => [
            'fullView' => true,
            'context' => 'public-contest',
        ],
        'summary' => false,
      ]);
    ?>
</div>
