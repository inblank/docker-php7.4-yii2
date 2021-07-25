<?php

namespace app\models;

use inblank\yii2\console\interfaces\ConsoleIdentityInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Простая модель работы с пользователем
 *
 * @property integer $id идентификатор пользователя
 * @property string $auth_key Ключ аутентификации
 * @property string $name Имя пользователя
 * @property string $login Логин пользователя
 * @property string $password_hash Хэш пароля пользователя
 * @property string $email Email пользователя
 * @property string $access_token Токен доступа
 */
class User extends ActiveRecord implements IdentityInterface, ConsoleIdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['access_token'], 'default', 'value' => function () {
                return $this->generateAccessToken();
            }],
            [['name', 'login', 'email', 'access_token'], 'required'],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 512],
            [['login'], 'string', 'max' => 50],
            [['login'], 'unique'],
            [['password_hash'], 'string', 'max' => 150],
            [['email'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'auth_key' => Yii::t('main', 'Auth Key'),
            'name' => Yii::t('main', 'Name'),
            'login' => Yii::t('main', 'Login'),
            'password_hash' => Yii::t('main', 'Password Hash'),
            'email' => Yii::t('main', 'Email'),
            'access_token' => Yii::t('main', 'Access Token'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString(32);
    }

    /**
     * Generate new access token
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAccessToken(): string
    {
        return $this->access_token = Yii::$app->security->generateRandomString(32);
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentityByLogin(string $login): ?self
    {
        return static::findOne(['login' => $login]);
    }
}