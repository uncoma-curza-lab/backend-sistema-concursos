<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DocuementType]].
 *
 * @see DocuementType
 */
class DocumentsTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DocuementType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DocuementType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function forPresident()
    {
        return $this->where(['=', 'code', 'dictamen']);
    }

    public function forRegularContest()
    {
        return $this->where(['<>', 'code', 'resolución-aprobatoria-del-concurso-y-comisión-evaluadora']);
    }

}
