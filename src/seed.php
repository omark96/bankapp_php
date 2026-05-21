<?php

use Core\Database;

/**
 * @var Database $db
 */

$users = [
    [
        'card_number' => '1234',
        'pin' => '1234',
        'name' => 'John User',
        'role' => 'user'
    ],
    [
        'card_number' => '4321',
        'pin' => '4321',
        'name' => 'Joe Admin',
        'role' => 'admin'
    ]
];

foreach ($users as $user) {
    $db->query(
        "insert into users(card_number, pin_hash, name, role) VALUES (:card_number, :pin_hash, :name, :role)",
        [
            'card_number' => $user['card_number'],
            'pin_hash' => password_hash($user['pin'], PASSWORD_DEFAULT),
            'name' => $user['name'],
            'role' => $user['role'],
        ]
    );
}