<?php

namespace app\models\traits;


/**
 * create validation cuil from
 * maurozadu/CUIT-validator
 */
trait ValidateCUIL {


    public function validateCUIL($cuit, $params, $validator)
    {
        if (!$this->isValidCUIL($this->$cuit)) {
            $this->addError($cuit, 'Verifique el número de identificación');
        }

    }

    private function isValidCUIL($cuit)
    {
        $digits = array();
		if (strlen($cuit) != 11) return false;
		for ($i = 0; $i < strlen($cuit); $i++) {
			if (!ctype_digit($cuit[$i])) return false;
			$digits[] = $cuit[$i];
		}
		$acum = 0;
		foreach (array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2) as $i => $multiplicador) {
			$acum += $digits[$i] * $multiplicador;
		}
		$cmp = 11 - ($acum % 11);
		if ($cmp == 11) $cmp = 0;
		if ($cmp == 10) $cmp = 9;
		return ($cuit[10] == $cmp);
    }

}
