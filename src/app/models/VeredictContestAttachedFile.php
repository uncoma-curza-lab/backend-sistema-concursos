<?php

namespace app\models;

use app\events\PublishResolutionEvent;
use app\events\UploadResolutionEvent;
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
 * @property Contests $contest
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
            $this->setSaveOnlyScenario();

            if (!$this->save() || !$contest->finish()) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            $this->trigger('notify', new PublishResolutionEvent($contest));

            return true;

        } catch (\Throwable $e) {
           $transaction->rollBack();
           return false;
        }

    }
    
    public function upload() : bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        if(!parent::upload()){
            $transaction->rollBack();
            return false;
        }
        $contest = $this->contest;
        $contest->resolution_file_path = $this->path;
        if (!$contest->update()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        $this->trigger('notify', new UploadResolutionEvent($contest));
        return true;

    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $contest = $this->contest;
        $contest->resolution_file_path = null;
        return $contest->save();
    }

}
