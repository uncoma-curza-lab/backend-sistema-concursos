<?php

use app\rbac\IsJuryOfApprovedPostulation;
use yii\db\Migration;

/**
 * Class m231101_183817_load_permission
 */
class m231101_183817_load_permission extends Migration
{
    const PERMISSIONS = [
        'viewImplicatedPostulationProfile' => [
            'description' => 'View the profile and documentation of a Postulation',
            'rule' => IsJuryOfApprovedPostulation::class,
            'childs' => [
                'viewPostulations',
            ],
            'parent' => [
                'jury',
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
            if (array_key_exists('parent', $options)) {
                foreach($options['parent'] as $parentName) {
                    $permissionParent = $this->auth->createPermission($parentName);
                    $this->auth->addChild($permissionParent, $permission);
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
        $hasError = true;
        foreach(self::PERMISSIONS as $permissionName => $options) {
            $permission = $this->auth->createPermission($permissionName);
            if (array_key_exists('childs', $options)) {
                foreach($options['childs'] as $childName) {
                    $permissionChild = $this->auth->getPermission($childName);
                    $this->auth->removeChild($permission, $permissionChild);
                }
            }
            if (array_key_exists('parent', $options)) {
                foreach($options['parent'] as $parentName) {
                    $permissionParent = $this->auth->createPermission($parentName);
                    $this->auth->removeChild($permissionParent, $permission);
                }
            }
            $hasError = !$this->auth->remove($permission);
        }

        return !$hasError;
    }
}
