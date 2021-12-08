<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%permissions}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $code
 *
 * @property GroupPermission[] $groupPermissions
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permissions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['description'], 'string'],
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
            'description' => 'Description',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[GroupPermissions]].
     *
     * @return \yii\db\ActiveQuery|GroupPermissionQuery
     */
    public function getGroupPermissions()
    {
        return $this->hasMany(GroupPermission::className(), ['permission_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PermissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermissionsQuery(get_called_class());
    }
}
