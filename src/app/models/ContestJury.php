<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%contest_juries}}".
 *
 * @property int $id
 * @property int $contest_id
 * @property int $user_id
 * @property bool|null $is_president
 *
 * @property Contest $contest
 * @property User $user
 */
class ContestJury extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contest_juries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'user_id'], 'required'],
            [['contest_id', 'user_id'], 'default', 'value' => null],
            [['contest_id', 'user_id'], 'integer'],
            [['is_president'], 'boolean'],
            [['contest_id', 'user_id'], 'unique', 'targetAttribute' => ['contest_id', 'user_id']],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contests::class, 'targetAttribute' => ['contest_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contest_id' => 'Contest ID',
            'user_id' => 'User ID',
            'is_president' => 'Is President',
        ];
    }

    /**
     * Gets query for [[Contest]].
     *
     * @return \yii\db\ActiveQuery|ContestQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contests::className(), ['id' => 'contest_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ContestJuriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestJuriesQuery(get_called_class());
    }
}
