<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $user_to
 * @property string|null $message
 * @property bool|null $read
 * @property string|null $timestamp
 *
 * @property User $userTo
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_to'], 'required'],
            [['user_to'], 'integer'],
            [['message'], 'string'],
            [['read'], 'boolean'],
            [['read'], 'default', 'value' => false],
            [['timestamp'], 'safe'],
            [['user_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_to' => 'User To',
            'message' => 'Message',
            'read' => 'Read',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[UserTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_to']);
    }
}
