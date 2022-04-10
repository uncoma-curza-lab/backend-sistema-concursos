<?php

use app\helpers\Sluggable;
use app\modules\backoffice\Backoffice;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Sistemas de concursos',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'backoffice',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'es',
    'container' => [
        'definitions' => [
          \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
        ],
    ],
    'timeZone' => 'America/Argentina/Buenos_Aires',
    'components' => [
        'formatter' => [
            'class' => '\yii\i18n\Formatter',
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyyy HH:mm:ss',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qaH458KtJ7iQ-UlP6jB1VA6PqlA5bHYt',
            'parsers' => [
                'application/json'=>'yii\web\JsonParser'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'login',
                    'route' => 'site/login',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'signup',
                    'route' => 'register/signup',
                ],
                [
                    'pattern' => 'postulate/<slug:[\w\-]+>',
                    'route' => 'postulations/contest-inscription',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'postulations/downloadPdf/<postulationId:[\d]+>',
                    'route' => 'postulations/download-pdf',
                ],
                [
                    'pattern' => 'contests',
                    'route' => 'public-contest/index',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => '<controller:[\w\-]+>/<action:[\w\-]+>/<slug:[\w\-]+>',
                    'route' => '<controller>/<action>',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => '<controller:[\w\-]+>/<action:[\w\-]+>',
                    'route' => '<controller>/<action>',
                ],
            ],
        ], 
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'menu*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'backoffice*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'models*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'slug' => [
            'class' => Sluggable::class,
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\ApiModule',
        ],
        'backoffice' => [
            'class' => Backoffice::class,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['*', '::1'],
    ];
}

return $config;
