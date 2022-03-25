<?php

use yii\db\Migration;

/**
 * Class m220325_000205_add_view_implicated_permission_to_jury
 */
class m220325_000205_add_view_implicated_permission_to_jury extends Migration
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
        $permission = $this->auth->getPermission('viewImplicatedPostulations');

        $role = $this->auth->getRole('jury');
        $this->auth->addChild($role, $permission);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220325_000205_add_view_implicated_permission_to_jury cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220325_000205_add_view_implicated_permission_to_jury cannot be reverted.\n";

        return false;
    }
    */
}
