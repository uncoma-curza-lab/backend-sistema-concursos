<?php

namespace app\modules\api;

use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

/**
 * api module definition class
 */
class ApiModule extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

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
