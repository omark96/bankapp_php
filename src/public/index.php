<?php

use Core\Exceptions\ValidationException;
use Core\Response;
use Core\Router;
use Core\Session;
use Core\Exceptions\HttpException;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '../vendor/autoload.php';
require BASE_PATH . 'Core/utils.php';

require base_path('bootstrap.php');

$router = new Router();
$registerRoutes = require base_path('routes.php');
$registerRoutes($router);

$uri = $_SERVER['REQUEST_URI'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (TypeError $typeError) {
    $code = Response::BAD_REQUEST;
    $router->route("error/{$code}", 'get');
} catch (HttpException $exception) {
    $code = $exception->getCode();
    $router->route("error/{$code}", 'get');
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);
    redirect($router->previousUrl());
} catch (Throwable $exception) {
    dd($exception);
} finally {
    Session::unflash();
}