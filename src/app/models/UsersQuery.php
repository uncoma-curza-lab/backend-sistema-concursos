<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Users[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Users|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getByUsername($username)
    {
        return $this->findByUsername($username)->one();
    }

    public function findByUsername($username)
    {
        return $this->where(['=', 'uid', $username]);
    }
}
