<?php
$db = require(__DIR__ . '/db.php');
return [
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //'host' => 'smtp.mail.ru',
                //'username' => 'site@k1785.info',
                'host' => 'smtp.gmail.com',
                'username' => 'k1785.penza@gmail.com',
                'password' => 'phper1785',
                'port' => '587',
                'encryption' => 'tls'
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user','moder','admin'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'module/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User', 
            'enableAutoLogin' => true,
             // 'loginUrl' => ['user/login'],
             // ...
        ]
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ],
        'auth' => [
            'class' => 'app\modules\auth\Module',
        ],
         'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ]
    ]
];
