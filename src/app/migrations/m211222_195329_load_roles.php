<?php

use app\models\Users;
use yii\db\Migration;

/**
 * Class m211222_195329_load_roles
 */
class m211222_195329_load_roles extends Migration
{

    const ROLES = [
        'jury' => [
            'permissions' => [
                'specialPostulation',
            ],
        ],
        'director' => [
            'childRoles' => [
                'jury',
            ],
        ],
        'postulant' => [
            'permissions' => [
                'simplePostulation',
            ],
        ],
    ];
    protected $auth;

    public function __construct()
    {
        $this->auth = \Yii::$app->authManager;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach(self::ROLES as $roleName => $options) {
            $role = $this->auth->createRole($roleName);
            $this->auth->add($role);
            if (array_key_exists('permissions', $options)) {
                foreach($options['permissions'] as $permissionName) {
                    $permission = $this->auth->getPermission($permissionName);
                    $this->auth->addChild($role, $permission);
                }
            }
            if (array_key_exists('childRoles', $options)) {
                foreach($options['childRoles'] as $roleName) {
                    $roleChild = $this->auth->getRole($roleName);
                    $this->auth->addChild($role, $roleChild);
                }
            }
        }

        //TODO temporal
        $this->auth->assign($this->auth->getRole('postulant'),1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211222_195329_load_roles cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211222_195329_load_roles cannot be reverted.\n";

        return false;
    }
    */
}
