<?php

namespace app\models;

use Throwable;
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
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['active'], 'boolean']
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
            'active' => 'Active',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Gets query for [[Persons]].
     *
     * @return \yii\db\ActiveQuery|PersonsQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['user_id' => 'id']);
    }

    public function getContestJuriesRelation()
    {
        return $this->hasMany(ContestJury::class, ['user_id' => 'id']);
    }

    public function getContestsForJury()
    {
        return $this->hasMany(Contests::class, ['id' => 'contest_id'])
                    ->via('contestJuriesRelation');
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getUsername()
    {
        if (!$this->person) {
            return null;
        }
        return $this->person->first_name . ' ' . $this->person->last_name;
    }

    public static function create(array $attributes) : ?self
    {
        try {
            $user = new self();
            $user->load($attributes);
            $password = $user->setPassword($user->password);
            $user->active = true;
            $user->save();
            return $user;
        } catch(Throwable $e) {
            // TODO log
            return null;
        }
    }

    public function isValid(): bool
    {
        $person = $this->person;
        return $person && $this->active && $person->is_valid;

    }
}
