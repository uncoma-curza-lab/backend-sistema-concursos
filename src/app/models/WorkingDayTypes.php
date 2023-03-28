<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "working_day_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contests[] $contests
 */
class WorkingDayTypes extends \yii\db\ActiveRecord
{
    const PARTIAL_CODE = 'parcial';
    const EXLUSIVE_CODE = 'exlusiva';
    const SIMPLE_CODE = 'simple';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'working_day_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
     * Gets query for [[Contests]].
     *
     * @return \yii\db\ActiveQuery|ContestsQuery
     */
    public function getContests()
    {
        return $this->hasMany(Contests::className(), ['working_day_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return WorkingDayTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkingDayTypesQuery(get_called_class());
    }
}
