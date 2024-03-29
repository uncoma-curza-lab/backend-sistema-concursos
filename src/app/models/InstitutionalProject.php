<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public.institutional_projects".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 */
class InstitutionalProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public.institutional_projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
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
            'name' => ucfirst(Yii::t('models', 'name')),
            'code' => ucfirst(Yii::t('models', 'code')),
        ];
    }
}
