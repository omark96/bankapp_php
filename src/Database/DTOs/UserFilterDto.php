<?php

namespace Database\DTOs;

class UserFilterDto
{
    public function __construct(
        public ?string $cardNumber = null,
        public ?string $name = null,
        public ?string $role = null
    )
    {
    }
}