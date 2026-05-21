<?php


use Core\Database;
use Core\Response;
use Core\Router;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '../vendor/autoload.php';
require BASE_PATH . 'Core/utils.php';

require base_path('bootstrap.php');

$router = new Router();
$registerRoutes = require base_path('routes.php');
$registerRoutes($router);

$uri = $_SERVER['REQUEST_URI'];
$method = $_POST['method'] ?? $_SERVER['REQUEST_METHOD'];
try {
    $router->route($uri, $method);
} catch (TypeError $typeError) {
    abort(Response::BAD_REQUEST);
} catch (Throwable $exception) {
    dd($exception);
}
