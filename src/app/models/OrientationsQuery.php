<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Orientations]].
 *
 * @see Orientations
 */
class OrientationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Orientations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Orientations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
