<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orientations".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contests[] $contests
 */
class Orientations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orientations';
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
        return $this->hasMany(Contests::className(), ['orientation_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrientationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrientationsQuery(get_called_class());
    }
}
