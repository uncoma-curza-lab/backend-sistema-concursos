<?php

use app\rbac\IsContestCreator;
use app\rbac\IsJuryUser;
use app\rbac\IsMyProfile;
use app\rbac\NotIsJuryUser;
use app\rbac\ValidUserRule;
use yii\db\Migration;

/**
 * Class m211222_195227_load_rules
 */
class m211222_195227_load_rules extends Migration
{

    const RULES = [
        ValidUserRule::class,
        IsJuryUser::class,
        NotIsJuryUser::class,
        IsContestCreator::class,
        IsMyProfile::class,
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
        foreach(self::RULES as $rule) {
            $rule = new $rule;
            $this->auth->add($rule);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach(self::RULES as $rule) {
            $rule = new $rule;
            $isSuccessfullRemove = $this->auth->remove($rule->name);
            return !$isSuccessfullRemove;
        }
    }
}
