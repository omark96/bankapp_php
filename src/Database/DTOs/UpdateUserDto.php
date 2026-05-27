<?php

namespace Database\DTOs;

readonly class UpdateUserDto
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $role,
        public string $cardNumber
    )
    {
    }
}