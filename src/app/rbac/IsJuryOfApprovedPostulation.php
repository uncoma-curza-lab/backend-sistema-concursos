<?php

namespace app\rbac;

use app\models\Postulations;

class IsJuryOfApprovedPostulation extends IsJuryUser
{
    public $name = 'isJuryOfApprovedPostulation';

    /**
     * @param string|int $user el ID de usuario.
     * @param Item $item el rol o permiso asociado a la regla
     * @param array $params parámetros pasados a ManagerInterface::checkAccess().
     * @return bool un valor indicando si la regla permite al rol o permiso con el que está asociado.
     */
    public function execute($user, $item, $params)
    {
        if (!$postulationId = $params['postulationId']) {
            return false;
        }

        $postulation = Postulations::findOne($postulationId);

        $contestSlug = $postulation->contest->code;
        $params['contestSlug'] = $contestSlug;

        if (!parent::execute($user, $item, $params)) {
            return false;
        }

        return $postulation->isStatusAccepted();

    }
}
