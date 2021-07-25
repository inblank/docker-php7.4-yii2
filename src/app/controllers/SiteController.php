<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Web контроллер по-умолчанию
 */
class SiteController extends Controller
{
    /**
     * Действие контроллера по умолчанию
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', ['logoText' => Yii::t('main', 'Microservice')]);
    }
}