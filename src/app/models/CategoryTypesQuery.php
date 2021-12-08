<?php

namespace app\models;

use app\models\traits\FindBySlug;

/**
 * This is the ActiveQuery class for [[CategoryTypes]].
 *
 * @see CategoryTypes
 */
class CategoryTypesQuery extends \yii\db\ActiveQuery
{
    use FindBySlug;

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
