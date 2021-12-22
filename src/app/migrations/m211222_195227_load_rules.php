<?php

use app\rbac\IsJuryUser;
use app\rbac\ValidUserRule;
use yii\db\Migration;

/**
 * Class m211222_195227_load_rules
 */
class m211222_195227_load_rules extends Migration
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
        $rule = new ValidUserRule;
        $this->auth->add($rule);
        $rule = new IsJuryUser;
        $this->auth->add($rule);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $rule = new ValidUserRule;
        return $this->auth->remove($rule->name); //bool
    }
}
