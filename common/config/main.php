<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
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
