<?php

namespace app\modules\backoffice\models;

use app\models\User;
use Exception;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class EditProfileForm extends Model
{
    public $is_valid;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['is_valid'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'is_valid' => 'Valido?',
        ];
    }

    public function save($userId)
    {
        if (!$userId) {
            throw new Exception('save_role_to_user_error');
        }
        $user = User::find($userId)->one();
        if (!$user) {
            return false;
        }

        try {
            $user->active = true;
            $user->save();
            $person = $user->person;
            if (!$person) {
                // TODO?
            }

            $person->is_valid = true;
            $person->save();
            return true;

        } catch (Throwable $e) {

        }
        return false;

    }

}
