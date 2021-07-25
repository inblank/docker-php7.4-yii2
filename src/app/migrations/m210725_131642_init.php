<?php

use app\models\User;
use yii\db\Migration;

/**
 * Миграция для простой модели работы с пользователями
 */
class m210725_131642_init extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception|\yii\base\Exception
     */
    public function safeUp()
    {
        // Создание таблицы пользователей
        $tabUser = User::tableName();
        $this->createTable($tabUser, [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32),
            'name' => $this->string(512)->notNull(),
            'login' => $this->string(50)->notNull()->unique(),
            'password_hash' => $this->string(150),
            'email' => $this->string(256)->notNull(),
            'access_token' => $this->string(32)->notNull()->unique(),
        ]);

        // Комментарии к таблице
        $this->addCommentOnTable($tabUser, 'Таблица пользователей');
        $columnComments = [
            'id' => 'Идентификатор пользователя',
            'auth_key' => 'Ключ аутентификации',
            'name' => 'Имя пользователя',
            'login' => 'Логин пользователя',
            'password_hash' => 'Хэш пароля пользователя',
            'email' => 'Email пользователя',
            'access_token' => 'Токен доступа',
        ];
        foreach ($columnComments as $column => $comment) {
            $this->addCommentOnColumn($tabUser, $column, $comment);
        }

        // Индексы
        $indexesList = ['email' => false, 'login' => true];
        foreach ($indexesList as $columns => $unique) {
            $this->createIndex($tabUser, $columns, $unique);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool
    {
        $this->dropTable(User::tableName());
        return true;
    }
}
