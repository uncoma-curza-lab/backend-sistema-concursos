<?php

namespace app\models;

use app\events\UploadResolutionEvent;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

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
class ContestAttachedFile extends \yii\db\ActiveRecord
{
    public $resolution_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contest_attached_files';
    }

    public function behaviors() {
        return [
              [
                  'class' => TimestampBehavior::class,
                  'attributes' => [
                      ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                  ],
              ],
            'FormatDate' => [
                'class' => 'app\behaviors\FormatDate',
                  'attributes' => [
                      'created_at', 'published_at',
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
            [['resolution_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            [['resolution_file'], 'required'],
            [['contest_id', 'name', 'document_type_id'], 'required'],
            [['document_type_id'], 'documentTypeUnque'],
            [['contest_id', 'document_type_id', 'responsible_id'], 'default', 'value' => null],
            [['contest_id', 'document_type_id', 'responsible_id'], 'integer'],
            [['published'], 'boolean'],
            [['created_at', 'published_at'], 'safe'],
            [['name', 'path'], 'string', 'max' => 255],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contests::class, 'targetAttribute' => ['contest_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentResponsible::class, 'targetAttribute' => ['responsible_id' => 'id']],
            [['document_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::class, 'targetAttribute' => ['document_type_id' => 'id']],
        ];
    }

    public function documentTypeUnque()
    {
        $documentsTypes = $this->find()->inSameContest($this->contest_id)
                                       ->andWhere(['=', 'document_type_id', $this->document_type_id])
                                       ->count();
        if($documentsTypes){
            $this->addError('document_type_id', 'El Concuros ya posee un documento de este tipo');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contest_id' => Yii::t('models/contest-attached-files', 'contest'),
            'name' => Yii::t('models/contest-attached-files', 'name'),
            'document_type_id' => Yii::t('models/contest-attached-files', 'document_type'),
            'path' => Yii::t('models/contest-attached-files', 'path'),
            'responsible_id' => Yii::t('models/contest-attached-files', 'responsible'),
            'published' => Yii::t('models/contest-attached-files', 'published'),
            'created_at' => Yii::t('models/contest-attached-files', 'created_at'),
            'published_at' => Yii::t('models/contest-attached-files', 'published_at'),
        ];
    }

    /**
     * Gets query for [[Contest]].
     *
     * @return \yii\db\ActiveQuery|ContestQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contests::class, ['id' => 'contest_id']);
    }

    /**
     * Gets query for [[DocumentType]].
     *
     * @return \yii\db\ActiveQuery|DocumentsTypeQuery
     */
    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::class, ['id' => 'document_type_id']);
    }

    /**
     * Gets query for [[Responsible]].
     *
     * @return \yii\db\ActiveQuery|DocumentsResponsibleQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(DocumentResponsible::class, ['id' => 'responsible_id']);
    }

    /**
     * {@inheritdoc}
     * @return ContestAttachedFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestAttachedFileQuery(get_called_class());
    }

    public static function instantiate($attr)
    {
        return $attr['document_type_id'] === \Yii::$app->veredictDocumentTypeSingleton->getDocumentType()->id ? new VeredictContestAttachedFile() : new static();
    }

    public function upload() : bool
    {
        if($this->validate()){
            try {
                FileHelper::createDirectory('contest_attached_files/' . $this->contest->code);
                $name = 'contest_attached_files/' . $this->contest->code . '/'
                    . Yii::$app->slug->format($this->resolution_file->baseName . ' ' . date('Y-m-d H:i:s'))
                    . '.'
                    . $this->resolution_file->extension;
                $this->resolution_file->saveAs($name);
                $this->path = $name;
        
                return $this->save(false);

            } catch (\Throwable $e) {
                Yii::warning($e->getMessage(), 'contest_attached_files-upload');
                return false;
            }
        }

        return false;

    }

    public function changePublishedStatus() : bool
    {
        if($this->isPublished() && $this->canUnPublish()){
            $this->published = !$this->published;
        }else if(!$this->isPublished()) {
            $this->published = !$this->published;
            $this->published_at = date('Y-m-d H:i:s');
        } else {
            return false;
        }
        return $this->save(false);
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
        if (!parent::afterDelete()) {
            return false;
        }
        try {
            return FileHelper::unlink($this->path);
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'contest_attached_files-afterDelete');
            return false;
        }
    }

    public function isPublished() : bool
    {
        return !!$this->published;
    }

    public function canDelete() : bool
    {
        return !$this->contest->isFinished() && !$this->isPublished();
    }

    public function canUnPublish() : bool
    {
        //TODO - Cuando se puede despublicar??
        return !$this->contest->isFinished();
    }

    public function isVeredict() : bool
    {
        return $this->documentType->code === DocumentType::VEREDICT;
    }
}
