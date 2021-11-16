<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qualifications".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 * @property string|null $custom_institution
 * @property string|null $custom_grade_type
 * @property string|null $description
 * @property string|null $file_path
 * @property int $person_id
 *
 * @property Persons $person
 */
class Qualifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'person_id'], 'required'],
            [['person_id'], 'default', 'value' => null],
            [['person_id'], 'integer'],
            [['name', 'custom_institution', 'custom_grade_type', 'description', 'file_path'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['person_id' => 'id']],
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
            'custom_institution' => 'Custom Institution',
            'custom_grade_type' => 'Custom Grade Type',
            'description' => 'Description',
            'file_path' => 'File Path',
            'person_id' => 'Person ID',
        ];
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery|PersonsQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['id' => 'person_id']);
    }

    /**
     * {@inheritdoc}
     * @return QualificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QualificationsQuery(get_called_class());
    }
}
