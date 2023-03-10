<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 *
 * @property ContestAttachedFile[] $contestAttachedFiles
 */
class DocumentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_types';
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
     * @return \yii\db\ActiveQuery
     */
    public function getContestAttachedFiles()
    {
        return $this->hasMany(ContestAttachedFile::className(), ['document_type_id' => 'id']);
    }
}
