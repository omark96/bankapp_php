<?php

use Core\App;
use Core\Database;
use Core\ServiceContainer;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Database\Interfaces\UserRepository;
use Database\MySQL\MySQLAccountRepository;
use Database\MySQL\MySQLTransactionRepository;
use Database\MySQL\MySQLUserRepository;
use Http\Controllers\AccountController;
use Http\Controllers\HomeController;
use Http\Controllers\SessionController;
use Http\Controllers\Transactions\DepositController;
use Http\Controllers\Transactions\TransferController;
use Http\Controllers\Transactions\WithdrawController;

session_start();

$container = new ServiceContainer();

$container->singleton(Database::class, function () {
    $config = require base_path('config.php');
    return new Database($config['Database']);
});

$container->singleton(UserRepository::class, MySQLUserRepository::class);
$container->singleton(AccountRepository::class, MySQLAccountRepository::class);
$container->singleton(TransactionRepository::class, MySQLTransactionRepository::class);


$container->bind(SessionController::class);
$container->bind(HomeController::class);
$container->bind(AccountController::class);
$container->bind(DepositController::class);
$container->bind(WithdrawController::class);
$container->bind(TransferController::class);

App::setServices($container);


