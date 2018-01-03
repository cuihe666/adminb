<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/params-code.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],

    'aliases' => [
        '@mdm/admin' => '@vendor/mdmsoft/yii-admin',
    ],

    'components' => [
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD,
                    ]
                ],
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\UserBackend',
            'enableAutoLogin' => true,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['info'],
                    'logVars' => [],
                    'categories' => ['mylog'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //邮件配置 <-- 大交通2.0 -- ys>
        'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,//false 真实发送邮件至邮箱  true 将邮件发送至指定目录下，不会真实发送邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',
                'username' => 'yuanshuai@tangguogo.com',
                'password' => 'YSqwe123',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['yuanshuai@tangguogo.com'=>'机票保险业务运营后台操作异常通知']
            ],
        ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
//            '*'
            //这a里是允许访问的action
            //controller/action
        ]
    ],
    'params' => $params,

];



