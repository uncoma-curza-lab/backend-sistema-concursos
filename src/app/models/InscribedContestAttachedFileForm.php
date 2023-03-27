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

    public function save(int $contestId) : bool
    {
        $inscAttFile = new InscribedContestAttachedFile();
        $inscAttFile->contest_id = $contestId;
        $inscAttFile->created_at = date('Y-m-d H:i:s');
        return $inscAttFile->generateAndSave($this->text);
    }

}
