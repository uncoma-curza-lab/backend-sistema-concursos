<?php
namespace app\widgets\notifications;

use yii\base\Widget;

class NotificationsGrid extends Widget
{
    public $dataProvider;
    public $columns;
    public $options;

    public function init() {
        parent::init();
        if ( !isset($this->options['selectPaginationSize']) ) {
            $this->options['selectPaginationSize'] = false;
        }
        if ( !isset($this->options['markAllAsRead']) ) {
            $this->options['markAllAsRead'] = true;
        }
    }
    
    public function run(){
        return $this->render('notificationsGridView', [
            'dataProvider' => $this->dataProvider,
            'columns' => $this->columns,
            'options' => $this->options,
        ]);
    }
}
