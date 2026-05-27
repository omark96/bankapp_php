<?php

namespace Models;

use DateTimeImmutable;

class User
{
    public function __construct(
        public int               $id,
        public string            $cardNumber,
        private string           $pinHash,
        public string            $name,
        public string            $role,
        public DateTimeImmutable $createdAt,
        public bool              $deleted
    )
    {
    }

    public static function fromDb($user): ?self
    {
        if ($user) {
            $created_at = new DateTimeImmutable($user['created_at']);
            return new self(
                $user['id'],
                $user['card_number'],
                $user['pin_hash'],
                $user['name'],
                $user['role'],
                $created_at,
                $user['deleted']
            );
        }
        return null;
    }

    public function authenticate($pin)
    {
        return password_verify($pin, $this->pinHash);
    }
}