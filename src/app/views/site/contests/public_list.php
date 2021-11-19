<?php

use yii\widgets\ListView;

$this->title = 'Concursos publicados';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="public-contest container">
    <h2> <?= Yii::t('models/contest', 'plural'); ?></h2>

    <?=
      ListView::widget([
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
            'class' => 'd-flex flex-row flex-wrap justify-content-between',
        ],
        'summary' => false,
      ]);
    ?>
</div>
