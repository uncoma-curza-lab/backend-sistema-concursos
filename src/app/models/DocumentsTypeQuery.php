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
        return $this->where(['=', 'code', DocumentType::VEREDICT]);
    }

    public function forRegularContest()
    {
        return $this->where(['<>', 'code', DocumentType::APPROVAL_RESOLUTION_CONTEST_EVALUATION_COMMISSION]);
    }

    public function forNotRegularContest()
    {
        $resolutions = [
            DocumentType::APPROVAL_RESOLUTION_CONTEST,
            DocumentType::APPROVAL_RESOLUTION_STUDENT_JURY,
            DocumentType::APPROVAL_RESOLUTION_TEACHING_JURY,
            DocumentType::DRAW_RECORD
        ];
        return $this->where(['NOT IN', 'code', $resolutions]);
    }

    public function getVeredictId()
    {
        return $this->where(['=', 'code', DocumentType::VEREDICT])->one()->id;
    }

    public function getByCode(string $code)
    {
        return $this->where(['=', 'code', $code])->one();
    }

}
