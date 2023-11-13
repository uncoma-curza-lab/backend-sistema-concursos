<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
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

    const ACCEPTED_EXTENSIONS = ['pdf', 'jpg', 'png', 'jpeg'];

    const UPLOAD_MAX_SIZE = 2048;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal_files';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => fn() => gmdate('Y-m-d H:i:s')            
            ],
            'FormatDate' => [
                'class' => 'app\behaviors\FormatDate',
                  'attributes' => [
                      'valid_until', ActiveRecord::EVENT_AFTER_FIND => ['created_at']
                  ],
              ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'postulation_id', 'is_valid'], 'default', 'value' => null],
            [['person_id', 'postulation_id', 'is_valid'], 'integer'],
            [['is_valid'], 'default', 'value' => self::UNVALIDATED],
            [['document_type_code'], 'required'],
            [['document_type_code'], 'uniqueDocumentTypeRule'],
            [['valid_until', 'created_at', 'validated_at', 'description'], 'safe'],
            [['document_type_code', 'path'], 'string', 'max' => 255],
            [['document_type_code'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::class, 'targetAttribute' => ['document_type_code' => 'code']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::class, 'targetAttribute' => ['person_id' => 'id']],
            [['postulation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postulations::class, 'targetAttribute' => ['postulation_id' => 'id']],
        ];
    }

    public function uniqueDocumentTypeRule()
    {
        if($this->isNewRecord && in_array($this->document_type_code, DocumentType::UNIQUE_TYPES)){
            if(self::find()->loggedUser()->isDocumentType($this->document_type_code)->one()){
                $this->addError('document_type_code', "There are a file whith this type. You can have only one.");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => Yii::t('models/personal-files', 'description'),
            'person_id' => 'Person ID',
            'postulation_id' => 'Postulation ID',
            'document_type_code' => Yii::t('models/personal-files', 'document_type_code'),
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

    public static function instantiate($attr)
    {
        return $attr['postulation_id'] ? new PostulationFile() : new static();
    }

    protected function createMasterPath() : string
    {
        $person = $this->person;
        $personLastName = Yii::$app->slug->format($person->last_name, '_');
        $personFirstName = Yii::$app->slug->format($person->first_name, '_');
        return 'personal_files/' . $person->uid . '-' . $personLastName . '-' . $personFirstName;
    }

    protected function fileValidation(UploadedFile $file) : bool
    {
        $type = explode('/', $file->type)[1];
        return in_array($type, self::ACCEPTED_EXTENSIONS)
            && 
            $file->size <= self::UPLOAD_MAX_SIZE * 1024;
    }

    public function upload(UploadedFile $file) : bool
    {
        if($this->validate() && $this->fileValidation($file)){
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

    protected function canDelete() : bool
    {
        //TODO - Cuando puedo eliminar??
        //El archivo debe pertenecerle al usuario?
        //Cuando esté verificado con un concurso activo??
        if($this->person_id != \Yii::$app->user->identity->person->id){
            return false;
        }
        if ($this->isValid() && $this->hasContestActive()) {
            return false;
        }
        return true;
    }

    protected function hasContestActive() : bool
    {
        return $this->person->hasActiveContest();
    }

    public function isValid() : bool
    {
        if(!$this->is_valid || $this->isStatus(self::INVALID)){
            return false;
        }

        if($this->isStatus(self::VALID_WITH_UNTIL_DATE)){
            $valid_until = date_create($this->valid_until);
            return $valid_until > date_create();
        }

        return $this->isStatus(self::VALID_INDEFINITELY);

    }

    public function getValidationStatusName() : string
    {
        if(!$this->is_valid){
            return self::VALIDATION_STATUSES[self::UNVALIDATED];
        }
        return self::VALIDATION_STATUSES[$this->is_valid];

    }

    /**
     * Chequea si la validación expiró
     */
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
