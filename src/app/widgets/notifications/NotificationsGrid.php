<?php
namespace app\widgets\notifications;

use yii\base\Widget;

class NotificationsGrid extends Widget
{
    public $dataProvider;
    public $columns;

    public function init() {
        parent::init();
        $this->dataProvider = $this->dataProvider;
        $this->columns = $this->columns;
    }
    
    public function run(){
        return $this->render('notificationsGridView', [
            'dataProvider' => $this->dataProvider,
        ]);
    }
}
