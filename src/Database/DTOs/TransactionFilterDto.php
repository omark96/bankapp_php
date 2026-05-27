<?php

namespace Database\DTOs;


readonly class TransactionFilterDto
{
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $type = null
    )
    {
    }

}