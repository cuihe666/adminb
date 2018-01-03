<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        "authManager" => [
            "class" => 'yii\rbac\DbManager',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            //'password' => 123456,
            'port' => 6379,
            'database' => 0,
        ],
    ],
    // 配置语言`
    'language'=>'zh-CN',
    // 配置时区
    'timeZone'=>'Asia/Chongqing',

];