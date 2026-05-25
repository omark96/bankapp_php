<?php

namespace Database\Interfaces;

use Models\User;

interface UserRepository
{
    public function getByCardNumber(string $cardNumber): User;

    public function getAllPaginated(int $page, int $limit);
}