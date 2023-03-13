<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ContestAttachedFile]].
 *
 * @see ContestAttachedFile
 */
class ContestAttachedFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ContestAttachedFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ContestAttachedFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function allInSameContest($contestId)
    {
        return $this->where(['=', 'contest_id', $contestId])->all();
    }
}
