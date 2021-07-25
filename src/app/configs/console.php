<?php
/**
 * Конфигурация консольного приложения
 */

return yii\helpers\ArrayHelper::merge(
    // общие настройки
    require __DIR__ . '/common.php',

    // настройка консольного приложения
    [
        'controllerNamespace' => 'app\commands',
        'components' => [
            'log' => [
                'flushInterval' => 1,
                'targets' => [
                    'error' => ['exportInterval' => 1,],
                    'info' => ['exportInterval' => 1,],
                    'debug' => ['exportInterval' => 1,],
                    'profile' => ['exportInterval' => 1,],
                ],
            ],
            'user' => [
                'class' => 'inblank\yii2\console\components\User',
                'identityClass' => 'app\models\User',
            ]
        ],
    ],

    // локальные настройки
    file_exists(__DIR__ . '/config-local.php') ? include __DIR__ . '/config-local.php' : []
);
