<?php

namespace Database\DTOs;


class TransactionFilterDto
{
    public function __construct(
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?string $type = null
    )
    {
    }

}