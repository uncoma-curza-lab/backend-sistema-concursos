<?php
return [
    'prefix' => 'api',
    'rules' => [
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => 'health',
            'route' => 'health-check/index',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => '<controller:[\w\-]+>/<action:[\w\-]+>/<slug:[\w\-]+>',
            'route' => '<controller>/<action>',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => '<controller:[\w\-]+>/<action:\w+>',
            'route' => '<controller>/<action>',
        ],
    ]
];
