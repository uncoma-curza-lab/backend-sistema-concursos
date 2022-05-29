<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Contests[] $contests
 */
class CategoryTypes extends \yii\db\ActiveRecord
{

    const REGULARES_CODE = 'regulares';
    const INTERINOS_CODE = 'interinos';
    const SUPLENTES_CODE = 'supolente';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_types';
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
        return $this->hasMany(Contests::className(), ['category_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryTypesQuery(get_called_class());
    }

    public function is(string $code): bool
    {
        return $this->code === $code;
    }
}
