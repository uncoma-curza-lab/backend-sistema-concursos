<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contests[] $contests
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areas';
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
        return $this->hasMany(Contests::className(), ['area_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreasQuery(get_called_class());
    }
}
