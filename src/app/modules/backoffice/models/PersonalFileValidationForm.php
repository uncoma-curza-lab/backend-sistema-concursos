<?php

namespace app\modules\backoffice\models;

use yii\base\Model;

/**
 * Form is the model behind the contact form.
 */
class PersonalFileValidationForm extends Model
{
    public $idValid;
    public $expireDate;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['isValid'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'isValid' => 'Is Valid',
            'expireDate' => 'Expire Date',
        ];
    }

    public function save()
    {
        return true;
    }

}
