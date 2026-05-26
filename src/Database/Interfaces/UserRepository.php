<?php

namespace Database\Interfaces;

use Database\DTOs\UpdateUserDto;
use Models\User;

interface UserRepository
{
    public function getById(int $id): ?User;

    public function getByCardNumber(string $cardNumber): ?User;

    public function getAllPaginated(int $page, int $limit);

    public function update(UpdateUserDto $userDto): ?User;
}