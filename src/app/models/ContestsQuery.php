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

    public function complete($db = null) : self
    {
        return $this->with('workingDayType');
    }

    public function onlyPublic() : self
    {
        return $this->where(['<=', 'init_date', date('Y-m-d H:i:s')]);
    }

    public function sortBy(array $columns) : self
    {
        return $this->orderBy($columns);

    }
}
