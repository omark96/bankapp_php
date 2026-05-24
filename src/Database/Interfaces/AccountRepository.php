<?php

namespace Database\Interfaces;

use Core\Types\PaginatedArray;
use Models\Account;

interface AccountRepository
{
    public function getAllPaginated(int $page, int $limit): PaginatedArray;

    public function getById(int $id): ?Account;

    public function getAllByUserId(int $userId): array;


    public function insert(Account $account): bool;
}