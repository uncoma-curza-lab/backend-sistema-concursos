<?php

namespace app\modules\backoffice\models;

use app\models\PersonalFile;
use Yii;
use yii\base\Model;

/**
 * Form is the model behind the contact form.
 */
class PersonalFileValidationForm extends Model
{
    public $fileId;
    public $idValid;
    public $expireDate;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['idValid', 'fileId'], 'required'],
            [['expireDate'], 'string'],
            [['expireDate'], 'dateRule'],
        ];
    }

    public function dateRule()
    {
        $date = date_create($this->expireDate);
        if($date < date_create()){
            $this->addError('expireDate', 'Date must be greater than today');
        }
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

    public static function getValidationStatusList()
    {
        return [
            PersonalFile::VALID_INDEFINITELY => Yii::t('models/personal-files', 'valid_indefinitely'),
            PersonalFile::VALID_WITH_UNTIL_DATE => Yii::t('models/personal-files', 'valid_whith_until_date'),
            PersonalFile::INVALID => Yii::t('models/personal-files', 'invalid'),
        ];
    }
}
