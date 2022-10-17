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
 * @property string|null $url
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
            [['message', 'url'], 'string'],
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
            'url' => 'URL',
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

    public static function create(User $user, string $message, string $url) : bool
    {
        $notification = new self();
        $notification->user_to = $user->id;
        $notification->message = $message;
        $notification->url = $url;
        $notification->timestamp = date('Y-m-d h:m:s');

        return $notification->save();
    }

    public static function batchCreate(array $users, string $message, string $url) : int
    {
        $columnsNames = ['user_to', 'message', 'url', 'timestamp'];
        $notifications = array_map(
            function($user) use ($message, $url){
                $notification = new self();
                $notification->user_to = $user->id;
                $notification->message = $message;
                $notification->url = $url;
                $notification->timestamp = date('Y-m-d h:m:s');

                if($notification->validate()){
                    return [
                        $notification->user_to,
                        $notification->message,
                        $notification->url,
                        $notification->timestamp,
                    ];
                }
            }, $users);

        return \Yii::$app->db->createCommand()
                             ->batchInsert('notifications', $columnsNames, $notifications)->execute();
    }

    public function changeReadStatus() : bool
    {
        if(!$this->isMyNotification()){
            return false;
        }
        $this->read = !$this->read;
        return $this->save();
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
