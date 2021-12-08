<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Province]].
 *
 * @see Province
 */
class CityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Province[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Province|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
