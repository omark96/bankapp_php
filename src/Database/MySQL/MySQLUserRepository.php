<?php

namespace Database\MySQL;

use Core\Database;
use Database\Interfaces\UserRepository;
use Models\User;

class MySQLUserRepository implements UserRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getByCardNumber(string $cardNumber): User
    {
        $user = $this->db->query('select * from users where card_number = :cardNumber', [
            'cardNumber' => $cardNumber
        ])->find();


    }
}