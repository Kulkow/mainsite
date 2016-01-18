<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@uploadroot' => $_SERVER['DOCUMENT_ROOT'].'/upload',
        '@upload' => '/upload',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user','moder','admin'], //здесь прописываем роли
            //зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile' => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile' => '@common/components/rbac/rules.php'
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
                /*[
                    'host' => 'server2',
                    'port' => 11211,
                    'weight' => 50,
                ],*/
            ],
        ],
    ],
];
