<?php

namespace app\rbac;

use app\models\Contests;
use Yii;
use yii\rbac\Rule;

class IsPresident extends Rule
{
    public $name = 'isPresident';

    /**
     * @param string|int $user el ID de usuario.
     * @param Item $item el rol o permiso asociado a la regla
     * @param array $params parámetros pasados a ManagerInterface::checkAccess().
     * @return bool un valor indicando si la regla permite al rol o permiso con el que está asociado.
     */
    public function execute($user, $item, $params)
    {
        if (!$contestSlug = $params['contestSlug']) {
            return false;
        }

        $contest = Contests::find()->getBySlug($contestSlug);

        foreach($contest->juries as $jury) {
            if ($jury->id === $user) {
                return true;
            }
        }

        return false;
    }
}
