<?php

namespace app\modules\backoffice\models;

use app\models\ContestJury;
use app\models\Contests;
use Exception;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddJuryForm extends Model
{
    public $userId;
    public $isPresident;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            ['isPresident', 'boolean'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'isPresident' => 'Es presidente?',
            'userId' => 'Usuario',
        ];
    }

    public function saveJury(int $contestId)
    {
        if (!$this->userId || !isset($this->isPresident)) {
            throw new Exception('save_jury_error');
        }

        $contestJury = new ContestJury();
        $contestJury->contest_id = $contestId;
        $contestJury->user_id = $this->userId;
        $contestJury->is_president = $this->isPresident;

        $contestJury->setJuryPermission($this->userId);

        $contestJury->save();
        return $contestJury;
    }

}
