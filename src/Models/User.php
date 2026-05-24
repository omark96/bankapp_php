<?php

namespace Models;

class User
{
    public function __construct(
        public int     $id,
        private string $cardNumber,
        private string $pinHash,
        public string  $name,
        public string  $role
    )
    {
    }

    public static function fromDb($user): ?self
    {
        if ($user) {
            return new self(
                $user['id'],
                $user['card_number'],
                $user['pin_hash'],
                $user['name'],
                $user['role']
            );
        }
        return null;
    }

    public function authenticate($pin)
    {
        return password_verify($pin, $this->pinHash);
    }
}