# Структура

- **app** папка приложения
- **app/modules** папка модулей. Код каждого модуля должен располагаться в отдельной папке.
- **app/configs/modules** папка файлов конфигурации модулей. Рекомендуется подключать в конфигурационном файле **app/configs/config-local.php**

> Сборка включает в себя простую модель работы с пользователями **app\models\User** и миграцию для создания таблицы пользователей в базе.    

В сборку встроен **composer.phar** последней на момент создания образа версии. Для вызова введите **composer**

Образ поддерживает переменную окружения **ENVIRONMENT**. Если переменная установлена в **development** будут подключены модули **yii2-debug**, **yii2-gii** и установлены константы **YII_DEBUG = true** и **YII_ENV = dev**

# Файл конфигурации

Конфигурации располагаются в папке **app/configs**. Основные конфигурационные файлы:

- **common.php** общая конфигурация. Подключается как для консольных приложений, так и для веб приложений.
- **console.php** конфигурация для консольных приложений
- **web.php** конфигурация для web приложений

Конфигурации проверяют наличие файла **config-local.php**, содержащего локальную конфигурация, и если находят, подключают его.

Обычно локальная конфигурация используется для задания параметров доступа и иной информации которая зависит от приложения и 
которая не должна попасть в репозиторий. 

Так же в ней рекомендуется подключать конфигурации модулей.

## Пример локальной конфигурации config-local.php

```php
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
                'username' => 'app',
                'password' => 'secret',
                'charset' => 'utf8'
            ],
        ],
    ],
    // Подключаем конфигурации модулей
    [
        require __DIR__ . '/modules/module1.php'
    ]
);
```

### Пример конфигурации модуля module1.php

```php
<?php

/**
 * Конфигурация модуля "module1"
 */

return [
    'bootstrap' => ['module1'],
    'aliases' => [
        '@inblank/module1' => '@app/modules/module1/src'
    ],
    'modules' => [
        'module1' => [
            'class' => 'inblank\module1\Module',
            'path' => '@runtime/module1/tmp',
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'pgsql:host=postgres;dbname=module1',
                    'username' => 'module1',
                    'password' => 'secret2',
                    'charset' => 'utf8',
                ],
            ]
        ]
    ]
];
```

### Пример использования в docker-compose

```yml
version: "3"
services:
  yii:
    image: inblank/php7.4-yii2
    volumes:
      - /etc/timezone:/etc/timezone:ro
      - /etc/localtime:/etc/localtime:ro
      - ./modules:/var/www/app/modules
      - ./configs:/var/www/app/configs/modules
      - ./config-local.php:/var/www/app/configs/config-local.php
    environment:
      ENVIRONMENT: development
```