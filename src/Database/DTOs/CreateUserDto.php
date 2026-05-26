<?php

namespace Database\DTOs;

class CreateUserDto
{
    public function __construct(
        public readonly string $name = "",
        public readonly string $role = "",
        public readonly string $cardNumber = "",
        public readonly string $pinCode = ""
    )
    {
    }
}