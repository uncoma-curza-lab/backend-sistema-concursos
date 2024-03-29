<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
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
    const SCENARIO_SAVE_ONLY = 'save_only';
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
                  'value' => fn() => gmdate('Y-m-d H:i:s')            
              ],
            'FormatDate' => [
                'class' => 'app\behaviors\FormatDate',
                  'attributes' => [
                    'published_at',
                  ],
              ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SAVE_ONLY] = ['contest_id', 'name', 'document_type_id', 'responsible_id', 'path'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resolution_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'on' => self::SCENARIO_DEFAULT],
            [['resolution_file'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['contest_id', 'name', 'document_type_id', 'responsible_id'], 'required'],
            [['document_type_id'], 'documentTypeUnique', 'on' => self::SCENARIO_DEFAULT],
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

    public function documentTypeUnique()
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

    public function formName()
    {
        return 'ContestAttachedFile';
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

    public function getResolutionName()
    {
        return 'CURZA N.º ' . $this->name;
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

    public function setSaveOnlyScenario()
    {
        $this->scenario = self::SCENARIO_SAVE_ONLY;
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
                $this->setSaveOnlyScenario();
        
                return $this->save();

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
        $this->setSaveOnlyScenario();
        return $this->save();
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
        return !$this->isPublished();
    }

    public function canUnPublish() : bool
    {
        return !$this->contest->isFinished() && !$this->contest->postulations;
    }

    public function isVeredict() : bool
    {
        return static::class === VeredictContestAttachedFile::class;
    }
}
