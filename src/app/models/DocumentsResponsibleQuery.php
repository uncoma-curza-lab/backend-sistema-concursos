<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DocumentResponsible]].
 *
 * @see DocumentResponsible
 */
class DocumentsResponsibleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DocumentResponsible[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DocumentResponsible|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function forPresident()
    {
        return $this->where(['=', 'code', 'departamento']);
    }
}
