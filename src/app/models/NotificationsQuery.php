<?php

namespace app\models;

use app\models\traits\FindBySlug;

/**
 * This is the ActiveQuery class for [[Notifications]].
 *
 * @see Notifications
 */
class NotificationsQuery extends \yii\db\ActiveQuery
{
    use FindBySlug;

    /**
     * {@inheritdoc}
     * @return Notifications[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Notifications|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function myUnread()
    {
        return $this->andWhere(['=', 'read', 'false'])
                    ->andWhere(['=', 'user_to', \Yii::$app->user->id]);

    }
    
    public function countMyNew()
    {
        return $this->myUnread()->count();
    }

    public function allMyUnread()
    {
        return $this->myUnread()->all();
    }
}
