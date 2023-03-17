<?php

namespace app\models;

use app\models\ContestAttachedFile as ModelsContestAttachedFile;

/**
 * This is the model class for table "contest_attached_files".
 *
 * @property int $id
 * @property int $contest_id
 * @property string $name
 * @property int $document_type_id
 * @property string|null $path
 * @property int|null $responsible_id
 * @property bool|null $published
 *
 * @property Contest $contest
 * @property DocumentsType $documentType
 * @property DocumentsResponsible $responsible
 */
class VeredictContestAttachedFile extends ModelsContestAttachedFile
{

    public function changePublishedStatus() : bool
    {
        if($this->isPublished()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $contest = $this->contest;
        try {
            $this->published = !$this->published;
            $this->published_at = date('Y-m-d H:i:s');

            if (!$this->save(false) || !$contest->publishResolution()) {
                $transaction->rollBack();
                return false;
            }

            $contest->notifyPublishResolution();
            $transaction->commit();
            return true;

        } catch (\Throwable $e) {
           $transaction->rollBack();
           return false;
        }

    }

}
