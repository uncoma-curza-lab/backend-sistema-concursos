<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Notification;
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

    <?php
    NavBar::begin([
        'brandLabel' => 'Backoffice del ' . Yii::$app->name,
        'brandUrl' => '/backoffice/index',
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-secondary sticky-top',
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
        ['label' => 'Concursos', 'url' => ['/backoffice/contest'], 'options' => ['class' => 'd-flex align-items-center']],
    ];
    if ($roles && in_array('admin', $roles)) {
        $items[] = [
            'label' => 'Administrar',
            'items' => [
                 ['label' => 'Areas', 'url' => '/backoffice/area'],
                 ['label' => 'Orientaciones', 'url' => '/backoffice/orientation'],
                 ['label' => 'Provincias', 'url' => '/backoffice/provinces'],
                 ['label' => 'Ciudades', 'url' => '/backoffice/cities'],
                 ['label' => 'Proyectos Institucionales', 'url' => '/backoffice/institutional-project'],
                 ['label' => 'Usuarios', 'url' => '/backoffice/user'],
            ],
            'options' => ['class' => 'd-flex align-items-center']
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
        'options' => ['class' => 'd-flex align-items-center']
    ];
    $items[] = '<a class="btn btn-link nav-link d-flex align-items-center" href="/site/index"><i class="bi bi-house-door-fill"></i> Volver al inicio</a>';
    $notificationsCount = Notification::find()->countUnreadSessionUser();
    $showCount = $notificationsCount ? Html::tag('span', $notificationsCount,['class' => 'badge badge-info']) : '';
    $items[] = [
         'label' => Html::tag('i','' ,['class' => 'nav-icon bi bi-bell']) . $showCount,
            'url' => ['/notifications'],
            'options' => ['class' => 'd-flex align-items-center']
        ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $items,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

<div class="container mt-5 flex-shrink-0">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

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
