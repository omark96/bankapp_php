<?php

namespace Database\Interfaces;

use Core\Database;
use Models\User;

interface UserRepository
{
    public function getByCardNumber(string $cardNumber): User;
}