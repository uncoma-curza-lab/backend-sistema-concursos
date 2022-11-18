<?php
namespace app\widgets\notifications;

use yii\base\Widget;

class NotificationsGrid extends Widget
{
    public $dataProvider;
    public $columns;
    public $selectPaginationSize;

    public function init() {
        parent::init();
        if ( $this->selectPaginationSize == null ) {
            $this->selectPaginationSize = false;
        }
    }
    
    public function run(){
        return $this->render('notificationsGridView', [
            'dataProvider' => $this->dataProvider,
            'columns' => $this->columns,
            'selectPaginationSize' => $this->selectPaginationSize,
        ]);
    }
}
