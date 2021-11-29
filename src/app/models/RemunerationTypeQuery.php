<?php

namespace app\models;

use app\models\traits\FindBySlug;

class RemunerationTypeQuery extends \yii\db\ActiveQuery
{
    use FindBySlug;

    /**
     * {@inheritdoc}
     * @return RemunerationType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RemunerationType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
