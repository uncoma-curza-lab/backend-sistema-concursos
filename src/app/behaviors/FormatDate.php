<?php

namespace app\behaviors;
use yii\base\Behavior;
use yii\db\ActiveRecord;

//'FormatDate' => [
//	'class' => 'app\behaviors\FormatDate',
//	'attributes' => ['created_at', 'updated_at'],
//	'saveformat' => 'Y-M-d h:i:s',//defults to new Expression('NOW()')
//	'saveAsMySql'=>false,//must be set to false to change save format;
//	'viewformat' => 'Y-M-d h:i:s'
//]

class FormatDate extends Behavior {

	public $attributes;
	public $viewformat = 'd-m-Y H:i:s';
	public $saveformat = 'Y-m-d H:i:s';
	public $saveAsMySql = TRUE;

	public function events() {
    	return [
        	ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
        	ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        	ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
    	];
	}

	public function beforeSave($event) {

    	foreach ($this->attributes as $attribute) {
            if (isset($this->owner->$attribute) && !empty($this->owner->$attribute) && $this->owner->$attribute != null) {
                $this->owner->$attribute = (!$this->saveAsMySql) ? 
                    date($this->saveformat, strtotime($this->owner->$attribute))
                    :
                    date('Y-m-d H:i:s', strtotime($this->owner->$attribute));
            }
    	}
	}

	public function afterFind($event) {
    	foreach ($this->attributes as $attribute) {
        	if (isset($this->owner->$attribute) && !empty($this->owner->$attribute) && $this->owner->$attribute != null) {
            	$this->owner->$attribute = date($this->viewformat, strtotime($this->owner->$attribute));
        	} else {
            	$this->owner->$attribute = 'Not Set';
        	}
    	}
	}

}