<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%contest_statuses}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contests[] $contests
 */
class ContestStatus extends \yii\db\ActiveRecord
{
    const DRAFT = 1;
    const PUBLISHED = 2;
    const IN_PROCESS = 3;
    const FINISHED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contest_statuses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
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
        return $this->hasMany(Contests::className(), ['contest_status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ContestStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestStatusQuery(get_called_class());
    }
}
