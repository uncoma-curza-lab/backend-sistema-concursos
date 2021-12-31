<?php
return [
    'prefix' => 'backoffice',
    'rules' => [
        [
            'class' => '\yii\web\UrlRule',
            'pattern' => '<action:(index$|/$)*>',
            'route' => 'backoffice/index',
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
