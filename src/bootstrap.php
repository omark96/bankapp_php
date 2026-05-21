<?php

use controllers\ExampleImplementation;
use controllers\ExampleInterface;
use controllers\SessionController;
use Core\App;
use Core\Database;
use Core\ServiceContainer;
use Database\Interfaces\UserRepository;
use Database\MySQL\MySQLUserRepository;

$container = new ServiceContainer();

$container->bind(Database::class, function () {
    $config = require base_path('config.php');
    return new Database($config['Database']);
});

$container->bind(SessionController::class);

$container->bind(UserRepository::class, MySQLUserRepository::class);

App::setServices($container);


