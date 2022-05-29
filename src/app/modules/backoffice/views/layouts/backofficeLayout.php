<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title)  . ' - CURZA' ?></title>
    <?php $this->head() ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Backoffice del ' . Yii::$app->name,
        'brandUrl' => '/backoffice/index',
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-secondary fixed-top',
        ],
    ]);
    $loggedUser = Yii::$app->user;
    $roles = null;
    if ($loggedUser) {
        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
    }
    if (in_array('admin', $roles) || in_array('jury', $roles) || in_array('teach_departament', $roles))
    $items = [
        //['label' => Yii::t('menu', 'home'), 'url' => ['/backoffice/index']],
        ['label' => 'Concursos', 'url' => ['/backoffice/contest']],
    ];
    if ($roles && in_array('admin', $roles)) {
        $items[] = [
            'label' => 'Administrar',
            'items' => [
                 ['label' => 'Areas', 'url' => '/backoffice/area'],
                 ['label' => 'Orientaciones', 'url' => '/backoffice/orientation'],
                 ['label' => 'Provincias', 'url' => '/backoffice/provinces'],
                 ['label' => 'Ciudades', 'url' => '/backoffice/cities'],
                 ['label' => 'Usuarios', 'url' => '/backoffice/user'],
            ],
        ];
    }
    $items[]= [
        'label' => Yii::$app->user->identity->getUsername(),
        'items' => [
            [
                'label' => Yii::t('menu', 'Profile') ,
                'url' =>['/user/profile']
            ],
            [
                'label' => Yii::t('menu', 'logout'),
                'url' => '/site/logout',
                'linkOptions' =>  [ 'data-method' => 'post']
            ],
        ],
    ];
    $items[] = '<a class="btn btn-link nav-link" href="/site/index"><i class="bi bi-house-door-fill"></i> Volver al inicio</a>';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; CURZA - UNCOMA <?= date('Y') ?></p>
        <p class="float-right">Lab. IT</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
