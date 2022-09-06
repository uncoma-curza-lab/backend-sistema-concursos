<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;

    private $_user = false;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword'], 'required'],
            ['newPassword', 'string', 'min' => 6],
            // password is validated by validatePassword()
            ['oldPassword', 'validatePassword'],
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
        //var_dump($this->getUser() == \Yii::$app->user->identity);
        //exit;
        if (!$this->hasErrors()) {
            $user = $this->getUser();

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
         if (!$this->validate()) {
            return null;
        }
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = $this->getUser();
            $user->setPassword($this->newPassword);
        
            if (!$user->save()) {
                $transaction->rollBack();
                return null;
            }

            $transaction->commit();
            return $user;
        } catch(\Throwable $e) {
            \Yii::error($e);
            $transaction->rollBack();
            return null;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->getByUsername(\Yii::$app->user->identity['uid']);
        }

        return $this->_user;
    }

}
