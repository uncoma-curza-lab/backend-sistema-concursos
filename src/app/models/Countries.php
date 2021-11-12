<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 *
 * @property Provinces[] $provinces
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
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
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery|ProvincesQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Provinces::className(), ['country_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }
}
