<?php


/* @var $this yii\web\View */
/* @var $model app\models\Contests */

$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $view;
?>
<div class="contests-create">
     <div class="container">
       <div class="row">
         <div class="col-1">
             <nav class="nav flex-column">
               <a class="nav-link active" href="#">Active</a>
               <a class="nav-link" href="#">Link</a>
               <a class="nav-link" href="#">Link</a>
               <a class="nav-link disabled">Disabled</a>
             </nav>
         </div>
         <div class="col-11">
             <?= $this->render($view, $params) ?>
         </div>
       </div>
     </div>
</div>
