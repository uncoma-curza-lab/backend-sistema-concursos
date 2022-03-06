<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model 
{
    public $first_name;
    public $last_name;
    public $user_id;
    public $date_of_birth;
    public $country;
    public $city;
    public $province;
    public $is_valid;
    public $place_birth_country;
    public $place_birth_province;
    public $place_of_birth;
    public $uid;
    public $dni;
    public $contact_email;
    public $phone;
    public $cellphone;
    public $real_address;
    public $legal_address_country;
    public $legal_address_province;
    public $legal_address_city;
    public $legal_address;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'user_id'], 'required'],
            [['date_of_birth', 'validate_date'], 'safe'],
            [['place_of_birth', 'user_id'], 'default', 'value' => null],
            [['place_of_birth', 'user_id'], 'integer'],
            [['is_valid'], 'boolean'],
            [['first_name', 'last_name', 'uid', 'dni', 'contact_email', 'cellphone', 'phone', 'real_address', 'legal_address', 'citizenship'], 'string', 'max' => 255],
            [['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['place_of_birth' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => \Yii::t('app', 'first_name'),
            'last_name' => \Yii::t('app', 'last_name'),
            'uid' => \Yii::t('app', 'uid'),
            'dni' => \Yii::t('app', 'dni'),
            'contact_email' => \Yii::t('app', 'contact_email'),
            'cellphone' => \Yii::t('app', 'cellphone'),
            'phone' => \Yii::t('app', 'phone'),
            'real_address' => \Yii::t('app', 'real_address'),
            'legal_address' => \Yii::t('app', 'legal_address'),
            'citizenship' => 'Citizenship',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => \Yii::t('app', 'place_of_birth'),
            'user_id' => 'User ID',
            'valid_date' => 'Valid Date',
            'is_valid' => 'Is valid',
        ];
    }

    public function isPostulatedInContest(int $id) : bool
    {
        return $this->getPostulations()
                    ->where(['=', 'contest_id', $id])
                    ->exists();
    }

    /**
     * Gets query for [[PlaceOfBirth]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getPlaceOfBirth()
    {
        return $this->hasOne(City::className(), ['id' => 'place_of_birth']);
    }

    /**
     * Gets query for [[Postulations]].
     *
     * @return \yii\db\ActiveQuery|PostulationsQuery
     */
    public function getPostulations()
    {
        return $this->hasMany(Postulations::className(), ['person_id' => 'id']);
    }

    /**
     * Gets query for [[Qualifications]].
     *
     * @return \yii\db\ActiveQuery|QualificationsQuery
     */
    public function getQualifications()
    {
        return $this->hasMany(Qualifications::className(), ['person_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PersonsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonsQuery(get_called_class());
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
