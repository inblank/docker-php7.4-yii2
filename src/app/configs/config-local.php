<?php
/**
 * Локальная конфигурация
 */

return yii\helpers\ArrayHelper::merge(
    [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'pgsql:host=pgsql;dbname=app',
                'username' => 'root',
                'password' => 'blackmamba',
                'charset' => 'utf8'
            ],
        ],
    ],
    // Подключаем конфигурации модулей
    [
        // require __DIR__ . '/modules/module1.php'
    ]
);
