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
            [['date_of_birth'], 'safe'],
            [['place_of_birth', 'user_id'], 'default', 'value' => null],
            [['place_of_birth', 'user_id'], 'integer'],
            [['first_name', 'last_name', 'uid', 'dni', 'contact_email', 'cellphone', 'phone', 'real_address', 'legal_address', 'citizenship'], 'string', 'max' => 255],
            [['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['place_of_birth' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'uid' => 'Uid',
            'dni' => 'Dni',
            'contact_email' => 'Contact Email',
            'cellphone' => 'Cellphone',
            'phone' => 'Phone',
            'real_address' => 'Real Address',
            'legal_address' => 'Legal Address',
            'citizenship' => 'Citizenship',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth',
            'user_id' => 'User ID',
        ];
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
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
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
