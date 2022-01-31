<?php

namespace app\modules\backoffice\models;

use app\models\ContestJury;
use app\models\User;
use Exception;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UserForm extends Model
{
    public $uid;
    public $password;
    public $active;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['password'], 'string'],
            [['active'], 'boolean'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'User',
            'active' => 'Active',
        ];
    }

    public function save()
    {
        $user = User::find()->where(['=', 'uid', $this->uid])->one();
        if (!$user) {
            return false;
        }

        if ($this->password) {
            $user->setPassword($this->password);
        }
        $user->active = $this->active;
        $user->save();
        return true;
    }

}
