<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class InscriptionForm extends Model
{
    public $terms_accepted;
    public $contest;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['terms_accepted' ], 'required'],
            ['terms_accepted', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'terms_accepted' => \Yii::t('app', 'terms_accepted'),
        ];
    }

    public function save()
    {
        $postulations = new Postulations();
        $postulations->contest_id = $this->contest->id;
        $postulations->person_id = Yii::$app->user->identity->id;
        $postulations->save();
    }
}
