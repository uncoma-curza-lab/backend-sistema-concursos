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
 * @property Contests $contest
 * @property DocumentsType $documentType
 * @property DocumentsResponsible $responsible
 */
class InscribedContestAttachedFile extends ModelsContestAttachedFile
{

    public function generate()
    {
        var_dump('generate');
        exit;
    }

}
