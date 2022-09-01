<?php


/* @var $this yii\web\View */
/* @var $model app\models\Contests */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backoffice', 'contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $view;

$contestLinks = [];
$loggedUser = Yii::$app->user;
$roles = null;
if ($loggedUser) {
    $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
}

 if (in_array('admin', $roles) || in_array('jury', $roles) || in_array('teach_departament', $roles)) {
     //Notify when have postulations on pending status
     $notify = $params['model']->hasPendingPostulations() ? 'style="color: #E58B16;"' : '';
     array_push($contestLinks, Html::a(
         '<span class="bi bi-person-lines-fill" ' . $notify . ' aria-hidden="true"> Postulaciones</span>',
         Url::to(['postulation/contest', 'slug' => $params['model']->code]),
         ['title' => 'Postulaciones', 'class' => 'nav-link']
     ));
     
 }
 if (in_array('admin', $roles) || in_array('jury', $roles) || in_array('teach_departament', $roles)) {
     array_push($contestLinks, Html::a(
         '<span class="bi bi-folder-fill" aria-hidden="true"> Archivos</span>',
         ['contest/contest-files', 'contestId' => $params['model']->id],
         ['title' => 'Archivos', 'class' => 'nav-link']
     ));
 }
?>
<div class="contests-create">
     <div class="container">
       <div class="row">
         <div class="col-1">
             <nav class="nav flex-column">
               <?php 
                   foreach($contestLinks as $link){
                       echo $link;
                   }
               ?>
             </nav>
         </div>
         <div class="col-11">
             <?= $this->render($view, $params) ?>
         </div>
       </div>
     </div>
</div>
