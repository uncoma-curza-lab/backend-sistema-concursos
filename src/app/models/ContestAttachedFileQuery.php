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

    public function inSameContest($contestId)
    {
        return $this->andWhere(['=', 'contest_id', $contestId]);
    }

    public function onlyPublished()
    {
        return $this->andWhere(['=', 'published', true]);
    }

    public function onlyVeredict()
    {
        return $this->andWhere(['documents_types.code' => DocumentType::VEREDICT])
                    ->joinWith(['documentType']);
    }

    public function approvalResolution()
    {
        return $this->andWhere(['IN', 'documents_types.code', [
            DocumentType::APPROVAL_RESOLUTION_CONTEST,
            DocumentType::APPROVAL_RESOLUTION_CONTEST_EVALUATION_COMMISSION
        ]])->joinWith(['documentType']);
    }

}
