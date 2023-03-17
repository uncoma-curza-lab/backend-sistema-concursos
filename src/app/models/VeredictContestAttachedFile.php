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
}
