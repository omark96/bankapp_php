<?php

namespace Database\Interfaces;

use Core\Types\PaginatedArray;
use Database\DTOs\CreateUserDto;
use Database\DTOs\UpdateUserDto;
use Database\DTOs\UserFilterDto;
use Models\User;

interface UserRepository
{
    public function getById(int $id): ?User;

    public function getByCardNumber(string $cardNumber): ?User;

    public function getAllPaginated(UserFilterDto $filter, int $page, int $limit): PaginatedArray;

    public function update(UpdateUserDto $userDto): ?User;

    public function insert(CreateUserDto $userDto): ?User;

    public function delete(int $id): bool;
}