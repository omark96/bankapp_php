<?php

namespace Database\DTOs;

class UpdateUserDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $role,
        public readonly string $cardNumber
    )
    {
    }
}