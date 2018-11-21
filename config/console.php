<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$params['marketplace']['Binance']['key'] = '0ubnZxTBQeiregtOXf584sJZD37ytC3DwV7Tyar2TtZS8oai83vnOQX5YJ0DlOmE';
$params['marketplace']['Binance']['secret'] = '37j7rHQiGyciwQUlTGbH4QI5jB8QhgStYKy6kZbwQXufYckJYvMHW0Q1koZ4zSSv';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
