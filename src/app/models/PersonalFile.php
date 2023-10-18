<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "personal_files".
 *
 * @property int $id
 * @property string|null $description
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
class PersonalFile extends \yii\db\ActiveRecord
{
    const UNVALIDATED = 0;
    const VALID_INDEFINITELY = 1;
    const VALID_WITH_UNTIL_DATE = 2;
    const INVALID = 3;

    const VALIDATION_STATUSES = [
        self::UNVALIDATED => 'unvalidated',
        self::VALID_INDEFINITELY => 'valid_indefinitely',
        self::VALID_WITH_UNTIL_DATE => 'valid_with_until_date',
        self::INVALID => 'invalid'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'postulation_id', 'is_valid'], 'default', 'value' => null],
            [['person_id', 'postulation_id', 'is_valid'], 'integer'],
            [['document_type_code'], 'required'],
            [['valid_until', 'created_at', 'validated_at'], 'safe'],
            [['document_type_code', 'path'], 'string', 'max' => 255],
            [['document_type_code'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::class, 'targetAttribute' => ['document_type_code' => 'code']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::class, 'targetAttribute' => ['person_id' => 'id']],
            [['postulation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postulations::class, 'targetAttribute' => ['postulation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'person_id' => 'Person ID',
            'postulation_id' => 'Postulation ID',
            'document_type_code' => 'Document Type Code',
            'path' => 'Path',
            'is_valid' => 'Is Valid',
            'valid_until' => 'Valid Until',
            'created_at' => 'Created At',
            'validated_at' => 'Validated At',
        ];
    }

    /**
     * Gets query for [[DocumentTypeCode]].
     *
     * @return \yii\db\ActiveQuery|DocumentsTypeQuery
     */
    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::class, ['code' => 'document_type_code']);
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery|PersonQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::class, ['id' => 'person_id']);
    }

    /**
     * Gets query for [[Postulation]].
     *
     * @return \yii\db\ActiveQuery|PostulationQuery
     */
    public function getPostulation()
    {
        return $this->hasOne(Postulations::class, ['id' => 'postulation_id']);
    }

    /**
     * {@inheritdoc}
     * @return PersonalFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonalFileQuery(get_called_class());
    }

    protected function createMasterPath() : string
    {
        $person = $this->person;
        $personLastName = Yii::$app->slug->format($person->last_name, '_');
        $personFirstName = Yii::$app->slug->format($person->first_name, '_');
        return 'personal_files/' . $person->uid . '-' . $personLastName . '-' . $personFirstName;
    }

    public function upload(UploadedFile $file) : bool
    {
        if($this->validate()){
            try {
                $masterPath = $this->createMasterPath();

                FileHelper::createDirectory($masterPath);
                $name = $masterPath . '/'
                    . uniqid($this->document_type_code . '_')
                    . '.'
                    . $file->extension;
                $file->saveAs($name);
                $this->path = $name;
        
                return $this->save();

            } catch (\Throwable $e) {
                Yii::warning($e->getMessage(), 'personal_files-upload');
                return false;
            }
        }

        return false;
    }

    public function beforeDelete()
    {
         if (!parent::beforeDelete()) {
            return false;
        }
        return $this->canDelete();
    }

    public function afterDelete()
    {
        try {
            return FileHelper::unlink($this->path);
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'personal_files-afterDelete');
            return false;
        }
    }

    public function canDelete() : bool
    {
        //TODO - Cuando puedo eliminar??
        //El archivo debe pertenecerle al usuario?
        //Cuando esté verificado con un concurso activo??
        return true;
    }

    public function isValid() : bool
    {
        if(!$this->is_valid || $this->is_valid === self::INVALID){
            return false;
        }

        if($this->is_valid === self::VALID_WITH_UNTIL_DATE){
            $valid_until = date_create($this->valid_until);
            return $valid_until > date_create();
        }

        return $this->is_valid === self::VALID_INDEFINITELY;

    }

    public function getValidationStatusName() : string
    {
        if(!$this->is_valid){
            return self::VALIDATION_STATUSES[self::UNVALIDATED];
        }
        return self::VALIDATION_STATUSES[$this->is_valid];

    }

    public function isExpired() : bool
    {
        if($this->isStatus(self::VALID_WITH_UNTIL_DATE)){
            $valid_until = date_create($this->valid_until);
            return $valid_until < date_create();
        }
        return false;
    }

    public function isStatus(int $status) : bool 
    {
        return $this->is_valid === $status;
    }

    public function getDocumentsTypes()
    {
        return DocumentType::find()->forPersonalFiles()->all();
    }

    public function getFilesUrl() : array
    {
        return ['my-files'];
    }

}
