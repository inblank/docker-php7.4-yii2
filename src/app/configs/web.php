<?php
/**
 * Конфигурация веб приложения
 */

return yii\helpers\ArrayHelper::merge(
    // общие настройки
    include __DIR__ . '/common.php',

    // настройки веб приложения
    [
        'controllerNamespace' => 'app\controllers',
        'components' => [
            'request' => [
                // отключаем проверку cookie
                'enableCookieValidation' => false,
                // отключаем CSRF cookie
                'enableCsrfCookie' => false,
            ],
            'urlManager' => [
                'class' => 'yii\web\UrlManager',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
            ],
            'user' => [
                'class' => 'yii\web\User',
                'identityClass' => 'app\models\User',
                'enableSession' => false,
            ],
        ],
    ],

    // локальные настройки
    file_exists(__DIR__ . '/config-local.php') ? include __DIR__ . '/config-local.php' : []
);
