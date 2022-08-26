<?php

namespace app\models;

use app\models\traits\FindBySlug;

/**
 * This is the ActiveQuery class for [[Contests]].
 *
 * @see Contests
 */
class ContestsQuery extends \yii\db\ActiveQuery
{
    use FindBySlug;

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

    public function complete() : self
    {
        return $this->with([
            'workingDayType',
            'remunerationType',
            'categoryType',
            'orientation',
            'area'
        ]);
    }

    public function onlyPublic() : self
    {
        return $this->where(['in', 'contest_status_id', ContestStatus::publicContestStatus()]);
    }

    public function onlyPublicAndInitiated() : self
    {
        return $this->where(['in', 'contest_status_id', ContestStatus::publicContestStatus()])
                    ->andWhere(['<=', 'init_date', date('Y-m-d H:i:s')]);
    }

    public function sortBy(array $columns) : self
    {
        return $this->orderBy($columns);

    }

    public function filterBySlug($slug)
    {
        return $this->where(['=', 'code', $slug]);
    }

    public function getBySlug($slug)
    {
        return $this->onlyPublic()->filterBySlug($slug)->one();
    }
}
