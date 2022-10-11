<?php
namespace app\widgets\notifications;

use yii\base\Widget;

class NotificationsGrid extends Widget
{
    public $dataProvider;
    public $columns;

    public function init() {
        parent::init();
        $this->dataProvider = $this->dataProvider->getModels();
        $this->columns = $this->columns;
    }
    
    public function run(){
        return $this->render('notificationsGridView', [
            'models' => $this->dataProvider,
        ]);
    }
}
