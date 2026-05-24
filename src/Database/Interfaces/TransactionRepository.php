<?php

namespace Database\Interfaces;

use Core\Types\PaginatedArray;
use Models\Transaction;

interface TransactionRepository
{
    public function getAllPaginated(int $page, int $limit): array;

    public function getById(int $id): ?Transaction;

    public function getAllByUserId(int $userId): array;

    public function getAllByUserIdPaginated(int $userId, int $page, int $limit): PaginatedArray;

    public function getAllByAccountId(int $accountId): array;

    public function getAllByAccountIdPaginated(int $accountId, int $page, int $limit): PaginatedArray;

    public function insert(Transaction $transaction): bool;
}