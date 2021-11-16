<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CategoryTypes]].
 *
 * @see CategoryTypes
 */
class CategoryTypesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CategoryTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoryTypes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
