<?php

namespace app\components;

use yii\base\Component;

class VeredictDocumentTypeSingleton extends Component
{
    private $_documentType;

    public function __construct($config = [])
    {
        $this->_documentType = $config['documentType']();
    }

    public function getDocumentType()
    {
        return $this->_documentType;
    }
}
