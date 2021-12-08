<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%groups}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $code
 *
 * @property GroupPermission[] $groupPermissions
 * @property UserGroup[] $userGroups
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%groups}}';
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
        return $this->hasMany(GroupPermission::className(), ['group_id' => 'id']);
    }

    /**
     * Gets query for [[UserGroups]].
     *
     * @return \yii\db\ActiveQuery|UserGroupQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroup::className(), ['group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupQuery(get_called_class());
    }
}
