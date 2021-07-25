<?php
/**
 * Конфигурация для команды 'yii message/extract'
 */
return [
    'color' => null,
    'interactive' => true,
    'help' => false,
    'silentExitOnException' => null,
    'sourcePath' => '@app',
    'messagePath' => '@app/messages',
    'languages' => ['ru'],
    'translator' => 'Yii::t',
    'sort' => true,
    'overwrite' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '/messages',
    ],
    'only' => [
        '*.php',
    ],
    'format' => 'php',
    'db' => 'db',
    'sourceMessageTable' => '{{%source_message}}',
    'messageTable' => '{{%message}}',
    'catalog' => 'messages',
    'ignoreCategories' => [],
    'phpFileHeader' => '',
    'phpDocBlock' => null,
];
