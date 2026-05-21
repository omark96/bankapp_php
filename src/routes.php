<?php

use controllers\HomeController;
use controllers\SessionController;
use Core\Router;

return function (Router $router) {
    $router->get('/', HomeController::class, 'index');
    $router->get('/about', HomeController::class, 'about');
    $router->get('/session/create', SessionController::class, 'create');
    $router->post('/session', SessionController::class, 'store');
    $router->get('/{id}', HomeController::class, 'test');
};

