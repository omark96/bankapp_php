<?php

namespace Models;

use DateTimeImmutable;

class Transaction
{
    public function __construct(
        public int               $id,
        public ?int              $fromAccountId,
        public ?int              $toAccountId,
        public string            $type,
        public string            $amount,
        public DateTimeImmutable $createdAt
    )
    {
    }

    public static function fromDb(array $transaction): ?self
    {
        if ($transaction) {
            $created_at = new DateTimeImmutable($transaction['created_at']);
            return new self(
                $transaction['id'],
                $transaction['from_account_id'],
                $transaction['to_account_id'],
                $transaction['type'],
                $transaction['amount'],
                $created_at
            );
        }
        return null;
    }

    public function getSwedishType(): string
    {
        return match ($this->type) {
            "deposit" => "Insättning",
            "withdraw" => "Uttag",
            "transfer" => "Överföring",
            default => $this->type
        };
    }
}