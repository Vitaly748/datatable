<?php

use yii\db\Connection;

$config = [
    'id' => 'datatable',
    'name' => 'DataTable',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'f4T-TezDgVc1Gau5ipZj2sqkasoYp5H8',
        ],
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=datatable',
            'username' => 'datatable',
            'password' => 'datatable',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
];


return $config;
