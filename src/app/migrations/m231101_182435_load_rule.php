<?php

use app\rbac\IsJuryOfApprovedPostulation;
use yii\db\Migration;

/**
 * Class m231101_182435_load_rule
 */
class m231101_182435_load_rule extends Migration
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
        $rule = new IsJuryOfApprovedPostulation();
        return $this->auth->add($rule);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $rule = new IsJuryOfApprovedPostulation();
        return $this->auth->remove($rule);
    }
}
