<?php

use app\rbac\IsJuryUser;
use app\rbac\ValidUserRule;
use yii\db\Migration;

/**
 * Class m211222_195233_load_permissions
 */
class m211222_195233_load_permissions extends Migration
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
        $permission = $this->auth->createPermission('postulateContest');
        $permission->description = 'Generate a new postulation for the contest';
        $this->auth->add($permission);
        $permission = $this->auth->createPermission('simplePostulation');
        $permission->ruleName = (new ValidUserRule)->name;
        $this->auth->add($permission);
        $permission = $this->auth->createPermission('specialPostulation');
        $permission->ruleName = (new IsJuryUser)->name;
        $this->auth->add($permission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211222_195233_load_permissions cannot be reverted.\n";

        return false;
    }

}
