<?php

namespace app\rbac\helpers;

class BackofficeRolesAccess
{
    const BACKOFFICE_ROLES = [
        'jury',
        'admin',
        'teach_departament',
    ];

    public static function canAccess() : bool
    {
        $user = \Yii::$app->user->identity;

        if (!$user) {
            return false;
        }

        $authManager = \Yii::$app->authManager;
        $userRoles = $authManager->getRolesByUser($user->id);

        foreach($userRoles as $roleKey => $roleObject) {
            if (in_array($roleKey, self::BACKOFFICE_ROLES)) {
                return true;
            }
        }

        return false;

    }
}
