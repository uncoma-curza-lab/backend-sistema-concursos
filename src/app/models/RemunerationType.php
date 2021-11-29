<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "remuneration_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contest[] $contests
 */
class RemunerationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remuneration_types';
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
     * @return \yii\db\ActiveQuery
     */
    public function getContests()
    {
        return $this->hasMany(Contest::className(), ['remuneration_type_id' => 'id']);
    }
}
