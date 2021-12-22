<?php

namespace app\rbac;

class NotIsJuryUser extends IsJuryUser 
{
    public $name = 'NotIsJuryUser';

    /**
     * @param string|int $user el ID de usuario.
     * @param Item $item el rol o permiso asociado a la regla
     * @param array $params parámetros pasados a ManagerInterface::checkAccess().
     * @return bool un valor indicando si la regla permite al rol o permiso con el que está asociado.
     */
    public function execute($user, $item, $params)
    {
        return !parent::execute($user, $item, $params);
    }
}
