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

    public static function find()
    {
        return new NotificationsQuery(get_called_class());
    }

    public static function create(User $user, string $message) : bool
    {
        $notification = new self();
        $notification->user_to = $user->id;
        $notification->message = $message;
        $notification->timestamp = date('Y-m-d h:m:s');

        return $notification->save();
    }

    public function markAsRead() : bool
    {
        if(!$this->canMarkAsRead()){
            return false;
        }
        $this->read = true;
        return $this->save();
    }

    public function markAsUnread() : bool
    {
        if(!$this->canMarkAsUnread()){
            return false;
        }
        $this->read = false;
        return $this->save();
    }

    public function canMarkAsUnread() : bool
    {
        return $this->isMyNotification() && $this->read;
    }

    public function canMarkAsRead() : bool
    {
        return $this->isMyNotification() && !$this->read;
    }

    public function isMyNotification() : bool
    {
        return \Yii::$app->user->id == $this->user_to;
    }

    public static function markAllAsRead() : bool
    {
        return self::updateAll(['read' => true],
            ['and',
                ['=', 'read', 'false'],
                ['=', 'user_to', \Yii::$app->user->id]
            ]);
    }
}
