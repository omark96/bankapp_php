<?php

use Core\Database;

require 'Core\Database.php';
require 'Core\utils.php';
$config = require 'config.php';
$db = new Database($config['Database']);

if (!in_array('seed', $argv)) {
    $schema = file_get_contents('schema.sql');
    $db->execute($schema);
}

require 'seed.php';
