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
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=datatable',
            'username' => 'datatable',
            'password' => 'datatable',
            'charset' => 'utf8',
        ],
    ],
];

return $config;
