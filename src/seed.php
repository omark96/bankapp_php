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
    ],
    [
        'id' => 3,
        'card_number' => '1212',
        'pin' => '1212',
        'name' => 'John User Jr',
        'role' => 'user'
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
        'account_type' => 'saving',
        'created_at' => '2026-01-02'
    ],
    [
        'id' => 3,
        'user_id' => 2,
        'account_type' => 'checking',
        'created_at' => '2026-01-03'
    ],
    [
        'id' => 4,
        'user_id' => 1,
        'account_type' => 'checking',
        'created_at' => '2026-01-06'
    ],
    [
        'id' => 5,
        'user_id' => 3,
        'account_type' => 'checking',
        'created_at' => '2026-05-05'
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
        'created_at' => '2026-01-03'
    ],
    [
        'id' => 3,
        'from_account_id' => 1,
        'to_account_id' => 3,
        'type' => 'transfer',
        'amount' => 1000,
        'created_at' => '2026-01-05'
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
        'created_at' => '2026-02-03'
    ],
    [
        'id' => 6,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 1000,
        'created_at' => '2026-03-01'
    ],
    [
        'id' => 7,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 1000,
        'created_at' => '2026-03-02'
    ],
    [
        'id' => 8,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 450,
        'created_at' => '2026-03-05'
    ],
    [
        'id' => 9,
        'from_account_id' => null,
        'to_account_id' => 2,
        'type' => 'deposit',
        'amount' => 720,
        'created_at' => '2026-03-08'
    ],
    [
        'id' => 10,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 150,
        'created_at' => '2026-03-12'
    ],
    [
        'id' => 11,
        'from_account_id' => null,
        'to_account_id' => 3,
        'type' => 'deposit',
        'amount' => 890,
        'created_at' => '2026-03-15'
    ],
    [
        'id' => 12,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 340,
        'created_at' => '2026-03-18'
    ],
    [
        'id' => 13,
        'from_account_id' => null,
        'to_account_id' => 2,
        'type' => 'deposit',
        'amount' => 910,
        'created_at' => '2026-03-22'
    ],
    [
        'id' => 14,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 280,
        'created_at' => '2026-03-25'
    ],
    [
        'id' => 15,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 600,
        'created_at' => '2026-03-28'
    ],
    [
        'id' => 16,
        'from_account_id' => null,
        'to_account_id' => 4,
        'type' => 'deposit',
        'amount' => 430,
        'created_at' => '2026-04-02'
    ],
    [
        'id' => 17,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 770,
        'created_at' => '2026-04-05'
    ],
    [
        'id' => 18,
        'from_account_id' => null,
        'to_account_id' => 2,
        'type' => 'deposit',
        'amount' => 120,
        'created_at' => '2026-04-09'
    ],
    [
        'id' => 19,
        'from_account_id' => null,
        'to_account_id' => 5,
        'type' => 'deposit',
        'amount' => 550,
        'created_at' => '2026-04-14'
    ],
    [
        'id' => 20,
        'from_account_id' => 1,
        'to_account_id' => null,
        'type' => 'withdraw',
        'amount' => 830,
        'created_at' => '2026-04-18'
    ],
    [
        'id' => 21,
        'from_account_id' => null,
        'to_account_id' => 3,
        'type' => 'deposit',
        'amount' => 290,
        'created_at' => '2026-04-21'
    ],
    [
        'id' => 22,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 950,
        'created_at' => '2026-04-25'
    ],
    [
        'id' => 23,
        'from_account_id' => null,
        'to_account_id' => 2,
        'type' => 'deposit',
        'amount' => 480,
        'created_at' => '2026-04-28'
    ],
    [
        'id' => 24,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 610,
        'created_at' => '2026-05-02'
    ],
    [
        'id' => 25,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 190,
        'created_at' => '2026-05-06'
    ],
    [
        'id' => 26,
        'from_account_id' => 3,
        'to_account_id' => null,
        'type' => 'withdraw',
        'amount' => 880,
        'created_at' => '2026-05-10'
    ],
    [
        'id' => 27,
        'from_account_id' => null,
        'to_account_id' => 1,
        'type' => 'deposit',
        'amount' => 370,
        'created_at' => '2026-05-15'
    ]
];

$db->beginTransaction();

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

$db->commit();