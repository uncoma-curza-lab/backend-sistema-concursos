<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ContestJury]].
 *
 * @see ContestJury
 */
class ContestJuriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ContestJury[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ContestJury|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getByContestAndUser(int $userId, string $contestId)
    {
        return $this->joinWith([
            'user' => function($query) use ($userId){
                    $query->andWhere(['users.id' => $userId]);
            },
            'contest' => function($query) use ($contestId){
                    $query->andWhere(['contests.code' => $contestId]);
            }])
            ->one();
    }
}
