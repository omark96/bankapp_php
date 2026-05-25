<?php

namespace Models;

use DateTimeImmutable;

class Account
{
    public function __construct(
        public int               $id,
        public int               $userId,
        public string            $accountType,
        public DateTimeImmutable $createdAt,
        public float             $balance = 0,
    )
    {
    }

    public static function fromDb(array $account): ?self
    {
        if ($account) {
            $created_at = new DateTimeImmutable($account['created_at']);
            $balance = $account['incoming'] - $account['outgoing'];
            return new self(
                $account['id'],
                $account['user_id'],
                $account['account_type'],
                $created_at,
                $balance
            );
        }
        return null;
    }

    public function getSwedishType(): string
    {
        return match ($this->accountType) {
            "checking" => "Privatkonto",
            "saving" => "Sparkapitalkonto",
            default => $this->accountType
        };
    }
}