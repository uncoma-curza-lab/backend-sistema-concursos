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
            'class' => '\yii\web\UrlRule',
            'pattern' => 'juries/delete/<user:[\d]+>/<contest:[\w\-]+>',
            'route' => 'juries/delete',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => 'user/<action:[\w\-]+>/<id:\d+>',
            'route' => 'user/<action>',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => 'roles/replace-to-user/<userId:[\d]+>',
            'route' => 'roles/replace-to-user',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => 'postulation/approve/<postulationId:[\d]+>',
            'route' => 'postulation/approve',
        ],
        [
            'class' => 'yii\web\UrlRule',
            'pattern' => 'postulation/reject/<postulationId:[\d]+>',
            'route' => 'postulation/reject',
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
