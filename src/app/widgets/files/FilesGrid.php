<?php
namespace app\widgets\files;

use yii\base\Widget;

class FilesGrid extends Widget
{
    public $dataProvider;
    public $actionButtons;

    public function init() {
        parent::init();
        if( !$this->actionButtons ) {
            $this->actionButtons = [];
        }
        if( !isset($this->actionButtons['view']) ) {
            $this->actionButtons['view'] = false;
        }
        if( !isset($this->actionButtons['download']) ) {
            $this->actionButtons['download'] = false;
        }
        if( !isset($this->actionButtons['delete']) ) {
            $this->actionButtons['delete'] = false;
        }

    }
    
    public function run(){
        return $this->render('filesGridView', [
            'dataProvider' => $this->dataProvider,
            'actionButtons' => $this->actionButtons,
        ]);
    }
}
