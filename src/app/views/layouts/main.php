<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\NavbarGenerator;
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
<?php 

$description = "Sitio de la sede atlántica de la Universidad Nacional del Comahue";
$image = "https://admin.curza.uncoma.edu.ar/wp-content/uploads/2019/11/fondo_ingreso-2-560x292.jpg";
      /* google */
      echo '<meta itemprop="name" content="' . $this->title . '">';
      echo '<meta itemprop="description" content="'.$description.'">';
      echo '<meta itemprop="image" content="'.$image.'">';

?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    $logo = Html::img('@web/images/logo_blanco100x100.png', ['alt'=>'Logo_curza']) . ' ';
    $brandLabel = "<div class='logo d-flex align-items-center'>
                        $logo
                        <div class='logo-text'>
                            <div class='unco'>Universidad Nacional del Comahue</div>
                            <div class='description'>Centro Universitario Regional Zona Atlántica</div>
                            <div class='app-name'>" . Yii::$app->name . "</div>
                        </div>
                        <div class='app-name-movil'>" . Yii::$app->name . "</div>
                    </div>";
    NavBar::begin([
        'brandLabel' => $brandLabel,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-curza',
        ],
    ]);
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => NavbarGenerator::getItems(),
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

<footer class="bg-dark text-white mt-auto py-3">
    <div class="container">
      <div class="row">
        <div class="col">
            <p>&copy; CURZA - UNCOMA <?= date('Y') ?></p>
        </div>
        <div class="col-6 text-center mb-3">
            <h3>Contacto</h3>
            <h4>Centro Universitario Regional Zona Atlántica</h4>
            <h5>Departamento Docente</h5>
            <p class="m-1"><i class="bi bi-telephone"></i> (02920) 423198/422921 Int. 109</p>
            <i class="bi bi-envelope"></i><a class="text-light" href="mailto:departamento.docente@curza.uncoma.edu.ar" target="_blank"> departamento.docente@curza.uncoma.edu.ar</a>
        </div>
        <div class="col text-right">
            <p>Lab. IT</p>
        </div>
      </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
