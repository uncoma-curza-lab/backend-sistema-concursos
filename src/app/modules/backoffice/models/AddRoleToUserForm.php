<?php

namespace app\modules\backoffice\models;

use app\models\ContestJury;
use Exception;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddRoleToUserForm extends Model
{
    public $userId;
    public $role;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'user' => 'Usuario',
            'role' => 'Rol',
        ];
    }

    public function save($userId)
    {
        if (!$userId || !$this->role) {
            throw new Exception('save_role_to_user_error');
        }

        $authManager = Yii::$app->authManager;
        $authManager->assign($authManager->getRole($this->role), $userId);

        return true;
    }

}
