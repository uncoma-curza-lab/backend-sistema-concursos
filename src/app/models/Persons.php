<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $uid
 * @property string|null $dni
 * @property string|null $contact_email
 * @property string|null $cellphone
 * @property string|null $phone
 * @property string|null $real_address
 * @property string|null $legal_address
 * @property string|null $citizenship
 * @property string|null $date_of_birth
 * @property int|null $place_of_birth
 * @property int $user_id
 *
 * @property City $placeOfBirth
 * @property Postulations[] $postulations
 * @property Qualifications[] $qualifications
 * @property Users $user
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'user_id'], 'required'],
            [['date_of_birth', 'validate_date'], 'safe'],
            [['place_of_birth', 'user_id'], 'default', 'value' => null],
            [['place_of_birth', 'user_id', 'real_address_city_id', 'legal_address_city_id'], 'integer'],
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
                    'place_of_birth', 'real_address_city_id', 'legal_address_city_id'
                ], 
                'exist', 'skipOnError' => true, 'targetClass' => City::className(),
                'targetAttribute' => [
                    'place_of_birth' => 'id',
                    'real_address_city_id' => 'id',
                    'legal_address_city_id' => 'id'
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
            'date_of_birth' => \Yii::t('app', 'date_of_birth'),
            'place_of_birth' => \Yii::t('models/profile', 'place_of_birth'),
            'legal_address_city_id' => \Yii::t('models/profile', 'legal_address_city'),
            'real_address_city_id' => \Yii::t('models/profile', 'real_address_city'),
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

    public function getLegalAddressCity()
    {
        return $this->hasOne(City::className(), ['id' => 'legal_address_city_id']);
    }

    public function getRealAddressCity()
    {
        return $this->hasOne(City::className(), ['id' => 'real_address_city_id']);
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
     * Seters
     */
    public function setFirstName($value)
    {
        $this->first_name = strtoupper($value);
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

    public function isValid()
    {
        return $this->is_valid;
    }

    public function isMinCompleteDataForValidUser()
    {
        $data = array_keys(array_filter($this->getAttributes()));
        $required = [
            'first_name',
            'last_name',
            'real_address_city_id',
            'legal_address_city_id',
            'place_of_birth',
            'cellphone',
            'contact_email',
            'dni'
        ];

        foreach($required as $attribute) {
            if (!in_array($attribute, $data)) {
                return false;
            }
        }
        return true;
    }
}
