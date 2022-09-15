<?php


/* @var $this yii\web\View */
/* @var $model app\models\Contests */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

$contestLinks = [];
$loggedUser = Yii::$app->user;
$roles = null;
if ($loggedUser) {
    $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
}
 if (in_array('admin', $roles) || in_array('jury', $roles) || in_array('teach_departament', $roles)) {
     array_push($contestLinks, Html::a(
         '<i class="bi bi-eye-fill" aria-hidden="true"></i><span class="vnav-title" style="display: none"> Detalles</span>',
         Url::to(['/backoffice/contest/view', 'slug' => $params['model']->code]),
         ['title' => 'Detalles', 'class' => 'nav-link vnav-link px-0 vnav-close']
     ));

      //Notify when have postulations on pending status
     $notify = $params['model']->hasPendingPostulations() ? 'style="color: #E58B16;"' : '';
     array_push($contestLinks, Html::a(
         '<i class="bi bi-person-lines-fill" ' . $notify . ' aria-hidden="true"></i><span class="vnav-title" style="display: none"> Postulaciones</span>',
         Url::to(['postulation/contest', 'slug' => $params['model']->code]),
         ['title' => 'Postulaciones', 'class' => 'nav-link vnav-link px-0 vnav-close']
     ));

      array_push($contestLinks, Html::a(
         '<i class="bi bi-folder-fill" aria-hidden="true"></i><span class="vnav-title" style="display: none"> Archivos</span>',
         ['contest/contest-files', 'contestId' => $params['model']->id],
         ['title' => 'Archivos', 'class' => 'nav-link vnav-link px-0 vnav-close']
     ));

     array_push($contestLinks, Html::a(
         '<i class="bi bi-people-fill" aria-hidden="true"></i><span class="vnav-title" style="display: none"> Jurados</span>',
         Url::to(['juries/contest', 'slug' => $params['model']->code]),
         ['title' => 'Jurados', 'class' => 'nav-link vnav-link px-0 vnav-close']
     ));
 }
?>
<div class="contests-details">
       <div class="row align-items-center">
         <div id="column" class="col-md-auto">
             <nav class="nav flex-column vnav">
                <a id="btn-menu" href="" class="nav-link vnav-link px-0 vnav-close"><h4><i class="bi bi-list"></i><span class="vnav-title" style="display: none"> Menú</span></h4></a>
               <?php 
                   foreach($contestLinks as $link){
                       echo $link;
                   }
               ?>
             </nav>
         </div>
         <div class="col">
             <?= $this->render($view, $params) ?>
         </div>
       </div>
</div>
<?php 
$sideNavBar = <<< 'JS'
let show = false;
$('#btn-menu').click((e) => {
    e.preventDefault();
    if(!show){
        $('.vnav-title').show(200, () => {
            show = true
            $('.vnav-link').removeClass('vnav-close');
        })
    }
    
   if(show){
        $('.vnav-title').hide(200, () => {
            show = false
            $('.vnav-link').addClass('vnav-close');
        })
    }
})
JS;

$this->registerJs($sideNavBar, View::POS_READY, 'side-nav-bar');
?>

