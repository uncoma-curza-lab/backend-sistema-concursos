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

    public function unreadSessionUser()
    {
        return $this->andWhere(['=', 'read', 'false'])
                    ->andWhere(['=', 'user_to', \Yii::$app->user->id]);

    }
    
    public function countUnreadSessionUser()
    {
        return $this->unreadSessionUser()->count();
    }

    public function allUnreadSessionUser()
    {
        return $this->unreadSessionUser()->all();
    }
}
