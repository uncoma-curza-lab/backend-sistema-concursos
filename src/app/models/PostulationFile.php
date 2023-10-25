<?php

namespace app\models;

use app\models\PersonalFile as PersonalFile;
use Yii;

/**
 * This is the model that extends from PersonalFile model.
 *
 * @property int $id
 * @property int|null $person_id
 * @property int|null $postulation_id
 * @property string $document_type_code
 * @property string $path
 * @property int|null $is_valid
 * @property string|null $valid_until
 * @property string|null $created_at
 * @property string|null $validated_at
 *
 * @property DocumentsType $documentTypeCode
 * @property Person $person
 * @property Postulation $postulation
 */
class PostulationFile extends PersonalFile
{
    protected function createMasterPath() : string
    {
        $person = $this->person;
        $contestCode = $this->postulation->contest->code;
        $personLastName = Yii::$app->slug->format($person->last_name, '_');
        $personFirstName = Yii::$app->slug->format($person->first_name, '_');
        return 'personal_files/' . $person->uid . '-' . $personLastName . '-' . $personFirstName . '/' . $contestCode;
    }

    protected function hasContestActive(): bool
    {
        return !$this->postulation->contest->isFinished();
    }

    public function uniqueDocumentTypeRoule()
    {
        if($this->isNewRecord && in_array($this->document_type_code, DocumentType::UNIQUE_TYPES)){
            foreach(self::find()->postulation_files($this->postulation_id)->all() as $file){
                if($this->document_type_code == $file->document_type_code){
                    $this->addError('document_type_code', "There are a file whith this type. You can have only one.");
                }
            }
        }
    }

    public function getDocumentsTypes()
    {
        return DocumentType::find()->forPostulationFiles()->all();
    }

    public function getFilesUrl() : array
    {
        return ['postulation-files', 'postulationId' => $this->postulation_id];
    }

}

