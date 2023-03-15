<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents_responsibles".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 *
 * @property ContestAttachedFile[] $contestAttachedFiles
 */
class DocumentResponsible extends \yii\db\ActiveRecord
{
    const EVALUATION_COMMISSION = 'evaluation-commission';
    const TEACHER_DEPARTMENT = 'teacher-department';
    const BOARD = 'board';
    const DAENERY = 'daenery';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_responsibles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[ContestAttachedFiles]].
     *
     * @return \yii\db\ActiveQuery|ContestAttachedFileQuery
     */
    public function getContestAttachedFiles()
    {
        return $this->hasMany(ContestAttachedFile::className(), ['responsible_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DocumentsResponsibleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentsResponsibleQuery(get_called_class());
    }
}
