<?php

use Core\Router;
use Http\Controllers\AccountController;
use Http\Controllers\HomeController;
use Http\Controllers\SessionController;
use Http\Controllers\Transactions\DepositController;

return function (Router $router) {
    $router->get('/', HomeController::class, 'index');
    $router->get('/about', HomeController::class, 'about');
    $router->get('/error/{code}', HomeController::class, 'error');

    $router->get('/session/create', SessionController::class, 'create');
    $router->post('/session', SessionController::class, 'store');
    $router->delete('/session', SessionController::class, 'destroy');

    $router->get('/accounts', AccountController::class, 'index');
    $router->get('/accounts/{id}', AccountController::class, 'show');

    $router->get('/accounts/{id}/deposit', DepositController::class, 'create');
    $router->post('/accounts/{id}/deposit', DepositController::class, 'store');
};

