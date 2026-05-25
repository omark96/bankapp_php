<?php

use Core\Database;

/**
 * @var Database $db
 */

$users = [
    [
        'id' => 1,
        'card_number' => '1234',
        'pin' => '1234',
        'name' => 'John User',
        'role' => 'user'
    ],
    [
        'id' => 2,
        'card_number' => '4321',
        'pin' => '4321',
        'name' => 'Joe Admin',
        'role' => 'admin'
    ]
];

$accounts = [
    [
        'id' => 1,
        'user_id' => 1,
        'account_type' => 'checking',
        'created_at' => '2026-01-01'
    ],
    [
        'id' => 2,
        'user_id' => 1,
        'account_type' => 'checking',
        'created_at' => '2026-01-02'
    ],
    [
        'id' => 3,
        'user_id' => 2,
        'account_type' => 'checking',
        'created_at' => '2026-01-01'
    ],
    [
        'id' => 4,
        'user_id' => 1,
        'account_type' => 'checking',
        'created_at' => '2026-01-01'
    ]
];

$transactions = [
    [
        'id' => 1,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 2000,
        'created_at' => '2026-01-01'
    ],
    [
        'id' => 2,
        'from_account_id' => 1,
        'to_account_id' => 2,
        'type' => 'transfer',
        'amount' => 100,
        'created_at' => '2026-01-05'
    ],
    [
        'id' => 3,
        'from_account_id' => 1,
        'to_account_id' => 3,
        'type' => 'transfer',
        'amount' => 1000,
        'created_at' => '2026-01-01'
    ],
    [
        'id' => 4,
        'from_account_id' => null,
        'to_account_id' => 2,
        'type' => 'deposit',
        'amount' => 1000,
        'created_at' => '2026-02-01'
    ],
    [
        'id' => 5,
        'from_account_id' => 2,
        'to_account_id' => 1,
        'type' => 'transfer',
        'amount' => 1000,
        'created_at' => '2026-02-01'
    ],
    [
        'id' => 6,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 1000,
        'created_at' => '2026-03-01'
    ]
];

foreach ($users as $user) {
    $db->query(
        'insert into users(card_number, pin_hash, name, role) VALUES (:card_number, :pin_hash, :name, :role)',
        [
            'card_number' => $user['card_number'],
            'pin_hash' => password_hash($user['pin'], PASSWORD_DEFAULT),
            'name' => $user['name'],
            'role' => $user['role'],
        ]
    );
}

foreach ($accounts as $account) {
    $db->query(
        'insert into accounts(user_id, account_type, created_at) VALUES (:user_id, :account_type, :created_at)',
        [
            'user_id' => $account['user_id'],
            'account_type' => $account['account_type'],
            'created_at' => $account['created_at'],
        ]
    );
}

foreach ($transactions as $transaction) {
    $db->query(
        'insert into transactions(from_account_id, to_account_id, type, amount, created_at) VALUES (:from_account_id, :to_account_id, :type, :amount, :created_at)',
        [
            'from_account_id' => $transaction['from_account_id'],
            'to_account_id' => $transaction['to_account_id'],
            'type' => $transaction['type'],
            'amount' => $transaction['amount'],
            'created_at' => $transaction['created_at'],
        ]
    );
}