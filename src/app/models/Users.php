<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $uid
 * @property string|null $password
 * @property string|null $timestamp
 *
 * @property Persons[] $persons
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp'], 'safe'],
            [['uid', 'password'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'password' => 'Password',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[Persons]].
     *
     * @return \yii\db\ActiveQuery|PersonsQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::className(), ['user_id' => 'id']);
    }

    public function getContests()
    {
        return $this->hasMany(Contests::class, ['id' => 'contest_id'])
                    ->viaTable(ContestJury::class, ['user_id', 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
