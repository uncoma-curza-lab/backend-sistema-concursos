<?php
namespace app\models;

use app\models\traits\ValidateCUIL;
use yii\base\Model;

class SignupForm extends Model
{
    
    use ValidateCUIL;

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'string', 'min' => 2, 'max' => 255],

            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string', 'min' => 2, 'max' => 255],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'validateCUIL'],
            ['username', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'uid', 'message' => 'This username has already been taken.'],
            ['username', 'unique', 'targetClass' => Persons::class, 'targetAttribute' => 'uid', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => Persons::class, 'targetAttribute' => 'contact_email', 'message' => 'Ya existe registrado este correo'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app', 'signup_password'),
            'first_name' => \Yii::t('app', 'signup_first_name'),
            'last_name' => \Yii::t('app', 'signup_last_name'),
            'username' => \Yii::t('app', 'signup_document'),
            'email' => \Yii::t('app', 'signup_email'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->uid = $this->username;
            $user->setPassword($this->password);
        
            if (!$user->save()) {
                $transaction->rollBack();
                return null;
            }
            $person = new Persons();
            $person->contact_email = $this->email;
            $person->first_name = $this->first_name;
            $person->last_name = $this->last_name;
            $person->uid = $this->username;
            $person->user_id = $user->id;
            if(!$person->save()) {
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
}
