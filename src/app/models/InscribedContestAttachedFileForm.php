<?php 
namespace app\models;

use Yii;
use yii\base\Model;

class InscribedContestAttachedFileForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => Yii::t('models/InscribedContestAttachedFileForm', 'text'),
        ];
    }

}
