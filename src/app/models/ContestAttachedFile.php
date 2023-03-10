<?php

namespace app\models;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contest_attached_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'name', 'document_type_id'], 'required'],
            [['contest_id', 'document_type_id', 'responsible_id'], 'default', 'value' => null],
            [['contest_id', 'document_type_id', 'responsible_id'], 'integer'],
            [['published'], 'boolean'],
            [['name', 'path'], 'string', 'max' => 255],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contest::className(), 'targetAttribute' => ['contest_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentsResponsible::className(), 'targetAttribute' => ['responsible_id' => 'id']],
            [['document_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentsType::className(), 'targetAttribute' => ['document_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contest_id' => 'Contest ID',
            'name' => 'Name',
            'document_type_id' => 'Document Type ID',
            'path' => 'Path',
            'responsible_id' => 'Responsible ID',
            'published' => 'Published',
        ];
    }

    /**
     * Gets query for [[Contest]].
     *
     * @return \yii\db\ActiveQuery|ContestQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contest::className(), ['id' => 'contest_id']);
    }

    /**
     * Gets query for [[DocumentType]].
     *
     * @return \yii\db\ActiveQuery|DocumentsTypeQuery
     */
    public function getDocumentType()
    {
        return $this->hasOne(DocumentsType::className(), ['id' => 'document_type_id']);
    }

    /**
     * Gets query for [[Responsible]].
     *
     * @return \yii\db\ActiveQuery|DocumentsResponsibleQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(DocumentsResponsible::className(), ['id' => 'responsible_id']);
    }

    /**
     * {@inheritdoc}
     * @return ContestAttachedFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestAttachedFileQuery(get_called_class());
    }
}
