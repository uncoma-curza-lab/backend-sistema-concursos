<?php

use app\rbac\IsPresident;
use yii\db\Migration;

/**
 * Class m220324_225020_add_permission_upload_resolution
 */
class m220324_225020_add_permission_upload_resolution extends Migration
{
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
        $rule = new IsPresident();
        $this->auth->add($rule);

        $permission = $this->auth->createPermission('uploadResolution');
        $permission->description = 'Permiso para subir un dictament de concurso';
        $permission->ruleName = $rule->name;
        $this->auth->add($permission);

        $role = $this->auth->getRole('jury');
        $this->auth->addChild($role, $permission);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220324_225020_add_permission_upload_resolution cannot be reverted.\n";

        return false;
    }
}
