<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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
    public $real_address_street;
    public $real_address_number;
    public $real_address_country;
    public $real_address_province;
    public $real_address_city_id;
    public $legal_address_country;
    public $legal_address_province;
    public $legal_address_city_id;
    public $legal_address_street;
    public $legal_address_number;
    public $citizenship;
    public $validate_date;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'first_name',
                'last_name',
                'place_of_birth',
                'real_address_city_id',
                'real_address_street',
                'real_address_number',
                'legal_address_city_id',
                'legal_address_street',
                'legal_address_number',
                'dni',
                'date_of_birth',
                'cellphone',
                'user_id',
                'contact_email',
            ], 'required'],
            [['date_of_birth', 'validate_date'], 'safe'],
            [['place_of_birth', 'user_id'], 'default', 'value' => null],
            [
                [
                    'place_birth_country',
                    'place_birth_province',
                    'place_of_birth',
                    'user_id',
                    'real_address_country',
                    'real_address_province',
                    'real_address_city_id',
                    'legal_address_country',
                    'legal_address_province',
                    'legal_address_city_id',
                ],
                'integer'
            ],
            [['is_valid'], 'boolean'],
            [[
                'first_name', 'last_name', 'uid', 'dni',
                'contact_email', 'cellphone', 'phone',
                'real_address_street', 'legal_address_street',
                'real_address_number', 'legal_address_number',
                'citizenship'
            ], 'string', 'max' => 255],
            [
                [
                    'place_of_birth',
                    'real_address_city_id',
                    'legal_address_city_id',
                ], 
                'exist', 'skipOnError' => true, 'targetClass' => City::className(),
                'targetAttribute' => [
                    'place_of_birth' => 'id',
                    'real_address_city_id' => 'id',
                    'legal_address_city_id' => 'id'
                ]
            ],
            [
                [
                    'place_birth_country',
                    'real_address_country',
                    'legal_address_country',
                ], 
                'exist', 'skipOnError' => true, 'targetClass' => Countries::className(),
                'targetAttribute' => [
                    'place_birth_country' => 'id',
                    'real_address_country' => 'id',
                    'legal_address_country' => 'id',
                ]
            ],
            [
                [
                    'place_birth_province',
                    'real_address_province',
                    'legal_address_province',
                ], 
                'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(),
                'targetAttribute' => [
                    'place_birth_province' => 'id',
                    'real_address_province' => 'id',
                    'legal_address_province' => 'id',
                ]
            ],
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
            'first_name' => \Yii::t('models/profile', 'first_name'),
            'last_name' => \Yii::t('models/profile', 'last_name'),
            'uid' => \Yii::t('models/profile', 'uid'),
            'dni' => \Yii::t('models/profile', 'dni'),
            'contact_email' => \Yii::t('models/profile', 'contact_email'),
            'cellphone' => \Yii::t('models/profile', 'cellphone'),
            'phone' => \Yii::t('models/profile', 'phone'),
            'citizenship' => \Yii::t('models/profile', 'citizenship'),
            'date_of_birth' => \Yii::t('models/profile', 'date_of_birth'),
            'user_id' => 'User ID',
            'valid_date' => 'Valid Date',
            'is_valid' => 'Is valid',
            'place_birth_country' => \Yii::t('models/profile', 'place_birth_country'),
            'place_birth_province' => \Yii::t('models/profile', 'place_birth_province'),
            'place_of_birth' => \Yii::t('models/profile', 'place_of_birth'),
            'real_address_country' => \Yii::t('models/profile', 'real_address_country'),
            'real_address_province' => \Yii::t('models/profile', 'real_address_province'),
            'real_address_city_id' => \Yii::t('models/profile', 'real_address_city'),
            'real_address_street' => \Yii::t('models/profile', 'real_address_street'),
            'real_address_number' => \Yii::t('models/profile', 'real_address_number'),
            'legal_address_country' => \Yii::t('models/profile', 'legal_address_country'),
            'legal_address_province' => \Yii::t('models/profile', 'legal_address_province'),
            'legal_address_city_id' => \Yii::t('models/profile', 'legal_address_city'),
            'legal_address_street' => \Yii::t('models/profile', 'legal_address_street'),
            'legal_address_number' => \Yii::t('models/profile', 'legal_address_number'),
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

    public function save()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = \Yii::$app->user->identity;
            $person = $user->person ?? new Persons();
            if (!$person->user_id)
                $person->user_id = $user->id;
            

            $person->setAttributes($this->getAttributes());

            if ($person->isMinCompleteDataForValidUser()) {
                $person->is_valid = true;
            }

            $person->save();

            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
        return false;

    }

    public function populate(Persons $person) : void
    {
        $this->setAttributes($person->getAttributes());
        if ($person->place_of_birth) {
            $cityPlaceOfBirth = City::find()->getOneComplete($person->place_of_birth);
            $this->place_birth_province = $cityPlaceOfBirth->province->id;
            $this->place_birth_country = $cityPlaceOfBirth->province->country->id;
        }
        if ($person->real_address_city_id) {
            $cityRealAddress = City::find()->getOneComplete($person->real_address_city_id);
            $this->real_address_province = $cityRealAddress->province->id;
            $this->real_address_country = $cityRealAddress->province->country->id;
        }
        if ($person->legal_address_city_id) {
            $cityLegalAddress = City::find()->getOneComplete($person->legal_address_city_id);
            $this->legal_address_province = $cityLegalAddress->province->id;
            $this->legal_address_country = $cityLegalAddress->province->country->id;
        }
    }
}
