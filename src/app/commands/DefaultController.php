<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Консольный контроллер по умолчанию
 */
class DefaultController extends Controller
{
    /**
     * Действие по умолчанию
     * @return int
     */
    public function actionIndex(): int
    {
        Console::output(Yii::t('console', 'Microservice CLI controller'));
        Console::output(Yii::t('console', 'User: {login}', ['login' => Yii::$app->user->login]));
        return ExitCode::OK;
    }
}
