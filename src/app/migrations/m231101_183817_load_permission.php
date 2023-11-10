<?php

use app\rbac\IsJuryOfApprovedPostulation;
use yii\db\Migration;

/**
 * Class m231101_183817_load_permission
 */
class m231101_183817_load_permission extends Migration
{
    const PERMISSIONS = [
        'viewPostulationProfile' => [
            'description' => 'View the profile and documentation of a Postulation',
            'role' => [
                'teach_departament',
            ],
        ],
        'viewImplicatedPostulationProfile' => [
            'description' => 'View the profile and documentation of a Postulation that user is jury',
            'rule' => IsJuryOfApprovedPostulation::class,
            'childs' => [
                'viewPostulationProfile',
            ],
            'role' => [
                'jury',
            ],
        ],
        'approveOrRejectPostulation' => [
            'description' => 'Approve or Reject a Postulation',
            'role' => [
                'admin',
                'teach_departament'
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
            if (array_key_exists('role', $options)) {
                foreach($options['role'] as $roleName) {
                    $role = $this->auth->getRole($roleName);
                    $this->auth->addChild($role, $permission);
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
        foreach(array_reverse(self::PERMISSIONS) as $permissionName => $options) {
            $permission = $this->auth->getPermission($permissionName);
            if (array_key_exists('role', $options)) {
                foreach($options['role'] as $roleName) {
                    $role = $this->auth->getRole($roleName);
                    $this->auth->removeChild($role, $permission);
                }
            }
            if (array_key_exists('childs', $options)) {
                foreach($options['childs'] as $childName) {
                    $permissionChild = $this->auth->getPermission($childName);
                    $this->auth->removeChild($permission, $permissionChild);
                }
            }
            $hasError = !$this->auth->remove($permission);
        }

        return !$hasError;
    }
}
