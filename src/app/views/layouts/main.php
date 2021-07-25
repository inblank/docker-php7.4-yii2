<?php
/**
 * Основной шаблон сайта
 * @var $this \yii\web\View объект отображения для которого шаблон
 * @var $content string контент страницы
 */

use yii\helpers\Html;

$this->beginPage() 
?>
<!doctype html>
<html lang="<?= Yii::$app->language?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags()?>
    <title><?= Html::encode($this->title ?? 'Microservice')?></title>
    <link rel="stylesheet" href="/css/main.css"/>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<?= $content ?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>