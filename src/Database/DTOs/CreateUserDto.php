<?php

namespace Database\DTOs;

readonly class CreateUserDto
{
    public function __construct(
        public string $name = "",
        public string $role = "",
        public string $cardNumber = "",
        public string $pinCode = ""
    )
    {
    }
}