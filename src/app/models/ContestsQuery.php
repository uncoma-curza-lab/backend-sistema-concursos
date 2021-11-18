<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Contests]].
 *
 * @see Contests
 */
class ContestsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Contests[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Contests|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function complete($db = null)
    {
        return $this->with('workingDayType');
    }

}
