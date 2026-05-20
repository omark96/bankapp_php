<?php

use controllers\HomeController;
use Core\App;
use Core\Database;
use Core\Router;
use Core\ServiceContainer;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '../vendor/autoload.php';
require BASE_PATH . 'Core/utils.php';

$container = new ServiceContainer();

App::setServices($container);

$router = new Router();
$registerRoutes = require base_path('routes.php');
$registerRoutes($router);


$config = require base_path('config.php');
$db = new Database($config['database']);

$uri = $_SERVER['REQUEST_URI'];
$method = $_POST['method'] ?? $_SERVER['REQUEST_METHOD'];
$router->route($uri, $method);
