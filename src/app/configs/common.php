<?php

/**
 * Основная конфигурация приложения
 */

$config = [
    'id' => 'microservice',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@runtime' => '@app/runtime',
    ],
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'error' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/errors.log',
                ],
                'info' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/info.log',
                ],
                'debug' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                    'logFile' => '@runtime/logs/debug.log',
                ],
                'profile' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['profile'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/profile.log',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => ['class' => 'yii\i18n\PhpMessageSource']
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'timeZone' => 'Europe/Moscow',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=app',
            'username' => 'root',
            'password' => 'password',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ],
    ],
];

if (YII_ENV_DEV) {
    if (!defined('YII_CONSOLE') || YII_CONSOLE !== true) {
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            'allowedIPs' => defined('YII_DEBUG') && YII_DEBUG === true ? ['*'] : ['127.0.0.1', '::1'],
        ];
    }
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => defined('YII_DEBUG') && YII_DEBUG === true ? ['*'] : ['127.0.0.1', '::1'],
    ];
}

return $config;
