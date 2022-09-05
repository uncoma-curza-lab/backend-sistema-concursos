<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword'], 'required'],
            // password is validated by validatePassword()
            ['newPassword', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => \Yii::t('app', 'change_pass_old_password'),
            'newPassword' => \Yii::t('app', 'change_pass_new_password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = \Yii::$app->user;

            if (!$user || !$user->validatePassword($this->oldPassword)) {
                $this->addError($attribute, 'Contraseña incorrecta.');
            }
            if ($this->oldPassword == $this->newPassword) {
                $this->addError($attribute, 'La contraseña anterior es igual a la nueva.');
            }
        }
    }

    public function changePassword()
    {
        //code
    }
}
