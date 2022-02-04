<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ContestStatus]].
 *
 * @see ContestStatus
 */
class ContestStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ContestStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ContestStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
