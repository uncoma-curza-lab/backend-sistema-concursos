<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[WorkingDayTypes]].
 *
 * @see WorkingDayTypes
 */
class WorkingDayTypesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return WorkingDayTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return WorkingDayTypes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
