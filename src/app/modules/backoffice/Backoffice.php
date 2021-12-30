<?php

namespace app\modules\backoffice;

use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

/**
 * backoffice module definition class
 */
class Backoffice extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\backoffice\controllers';
    public $layout = 'backofficeLayout.php';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        $routeConfig = require __DIR__ . '/config/routes.php';
        $app->getUrlManager()->addRules([
            new GroupUrlRule($routeConfig)
        ], false);

    }
}
