<?php

namespace app\models\validators;

use yii\validators\Validator;

class ContestValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Se requieren campos';
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        // if not exist... 
        // $model->addError($attribute, message...);
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {

    }
}
