<?php

namespace app\models;

use app\models\traits\FindBySlug;

/**
 * This is the ActiveQuery class for [[Orientations]].
 *
 * @see Orientations
 */
class OrientationsQuery extends \yii\db\ActiveQuery
{
    use FindBySlug;

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
