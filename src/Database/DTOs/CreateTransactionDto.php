<?php

namespace Database\DTOs;

readonly class CreateTransactionDto
{
    public function __construct(
        public ?int   $fromAccountId,
        public ?int   $toAccountId,
        public string $type,
        public string $amount,
    )
    {
    }
}