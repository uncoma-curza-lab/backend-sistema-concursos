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
            //['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

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
        
        $user = new User();
        //$user->username = $this->username;
        //$user->email = $this->email;
        //$user->setPassword($this->password);
        //$user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        //
        //return $user->save() && $this->sendEmail($user) ? $user : null;
    }
}
