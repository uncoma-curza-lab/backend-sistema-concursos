<?php

use app\rbac\IsJuryUser;
use app\rbac\IsMyProfile;
use app\rbac\NotIsJuryUser;
use app\rbac\ValidUserRule;
use yii\db\Migration;

/**
 * Class m211222_195233_load_permissions
 */
class m211222_195233_load_permissions extends Migration
{
    const PERMISSIONS = [
        'postulateToContest' => [
            'description' => 'Generate a new postulation for the contest',
        ],
        'simplePostulation' => [
            'rule' => ValidUserRule::class,
            'childs' => [
                'postulateToContest',
            ],
        ],
        'specialPostulation' => [
            'rule' => NotIsJuryUser::class,
            'childs' => [
                'simplePostulation',
            ],
        ],
        'viewProfile' => [
        ],
        'viewMyProfile' => [
            'rule' => IsMyProfile::class,
            'childs' => [
                'viewProfile'
            ]
        ],
        'editProfile' => [
        ],
        'editMyProfile' => [
            'rule' => IsMyProfile::class,
            'childs' => [
                'editProfile'
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

        try {
        foreach(self::PERMISSIONS as $permissionName => $options) {
            $permission = $this->auth->createPermission($permissionName);
            if (array_key_exists('description', $options)) {
                $permission->description = $options['description'];
            }
            if (array_key_exists('rule', $options)) {
                $permission->ruleName = (new $options['rule'])->name;
            }
            $this->auth->add($permission);
            if (array_key_exists('childs', $options)) {
                foreach($options['childs'] as $childName) {
                    $permissionChild = $this->auth->getPermission($childName);
                    $this->auth->addChild($permission, $permissionChild);
                    
                }
            }
        }} catch(\Throwable $e) {
        var_dump($permission);
        throw $e;
            }
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
