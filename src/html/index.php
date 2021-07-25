<?php
/**
 * Основной файл запуска WEB приложения
 */

if (getenv('ENVIRONMENT') === 'development') {
    // работаем в окружении разработки
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    // работаем в "боевом" окружении
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

try {
    (new yii\web\Application(require __DIR__ . '/../app/configs/web.php'))->run();
} catch (\yii\web\UnauthorizedHttpException $e) {
    $error = ['code' => -32001, 'message' => 'Your request was made with invalid credentials'];
} catch (\Throwable $e) {
    if ($e instanceof \yii\web\HttpException && $e->statusCode === 403) {
        $error = ['code' => -32002, 'message' => 'Access denied', 'data' => ['method' => $e->getMessage()]];
    } else {
        $data = ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()];
        Yii::error($data, 'critical');
        $error = ['code' => -32603, 'message' => 'Internal error', 'data' => YII_ENV !== 'prod' ? $data : []];
    }
}
if (isset($error)) {
    header('Content-type: application/json');
    try {
        echo json_encode(
            ['jsonrpc' => '2.0', 'id' => null, 'error' => $error],
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    } catch (JsonException $e) {
        echo $error = '["jsonrpc" => "2.0", "id" => null, "error" => "Error in response data"';
    }
}