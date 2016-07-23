<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@uploadroot' => $_SERVER['DOCUMENT_ROOT'].'/upload',
        '@upload' => '/upload',
        '@mainsite' => 'http'.(! empty($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'],
    ],
    'components' => [
        /*'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user','moder','admin'], //здесь прописываем роли
            'itemFile' => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile' => '@common/components/rbac/rules.php'
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user','moder','admin'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            /*'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],*/
        ],
    ],
];
