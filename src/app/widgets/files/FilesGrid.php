<?php
namespace app\widgets\files;

use yii\base\Widget;

class FilesGrid extends Widget
{
    public $dataProvider;
    public $actionButtons;

    public function init() {
        parent::init();
    }
    
    public function run(){
        return $this->render('filesGridView', [
            'dataProvider' => $this->dataProvider,
            'actionButtons' => $this->actionButtons,
        ]);
    }
}
