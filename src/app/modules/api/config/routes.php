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
            'pattern' => '<controller:[\w\-]+>/<id:[\d]+>',
            'route' => '<controller>/one',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => '<controller:[\w\-]+>',
            'route' => '<controller>/all',
        ],
    ]
];
