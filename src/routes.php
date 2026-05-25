<?php

use Core\Router;
use Http\Controllers\AccountController;
use Http\Controllers\Admin\AccountController as AdminAccountController;
use Http\Controllers\Admin\AdminController;
use Http\Controllers\Admin\TransactionController;
use Http\Controllers\Admin\UserController as AdminUserController;
use Http\Controllers\HomeController;
use Http\Controllers\SessionController;
use Http\Controllers\Transactions\DepositController;
use Http\Controllers\Transactions\TransferController;
use Http\Controllers\Transactions\WithdrawController;

return function (Router $router) {
    $router->get('/', HomeController::class, 'index');
    $router->get('/about', HomeController::class, 'about');
    $router->get('/error/{code}', HomeController::class, 'error');

    $router->get('/session/create', SessionController::class, 'create')->allowed(['guest']);
    $router->post('/session', SessionController::class, 'store')->allowed(['guest']);
    $router->delete('/session', SessionController::class, 'destroy')->allowed(['admin', 'user']);

    $router->get('/accounts', AccountController::class, 'index')->allowed(['admin', 'user']);
    $router->get('/accounts/{id}', AccountController::class, 'show')->allowed(['admin', 'user']);

    $router->get('/accounts/{id}/deposit', DepositController::class, 'create')->allowed(['admin', 'user']);
    $router->post('/accounts/{id}/deposit', DepositController::class, 'store')->allowed(['admin', 'user']);

    $router->get('/accounts/{id}/transfer', TransferController::class, 'create')->allowed(['admin', 'user']);
    $router->post('/accounts/{id}/transfer', TransferController::class, 'store')->allowed(['admin', 'user']);

    $router->get('/accounts/{id}/withdraw', WithdrawController::class, 'create')->allowed(['admin', 'user']);
    $router->post('/accounts/{id}/withdraw', WithdrawController::class, 'store')->allowed(['admin', 'user']);

    $router->get('/admin', AdminController::class, 'index')->allowed(['admin']);

    $router->get('/admin/users', AdminUserController::class, 'index')->allowed(['admin']);
    $router->get('/admin/users/table', AdminUserController::class, 'table')->allowed(['admin']);
    $router->post('/admin/users/table', AdminUserController::class, 'table')->allowed(['admin']);

    $router->get('/admin/transactions', TransactionController::class, 'index')->allowed(['admin']);
    $router->get('/admin/transactions/table', TransactionController::class, 'table')->allowed(['admin']);
    $router->post('/admin/transactions/table', TransactionController::class, 'table')->allowed(['admin']);

    $router->get('/admin/accounts', AdminAccountController::class, 'index')->allowed(['admin']);
    $router->get('/admin/accounts/table', AdminAccountController::class, 'table')->allowed(['admin']);
    $router->post('/admin/accounts/table', AdminAccountController::class, 'table')->allowed(['admin']);
};

