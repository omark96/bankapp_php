<?php

namespace Database\Interfaces;

use Core\Types\PaginatedArray;
use Database\DTOs\CreateTransactionDto;
use Database\DTOs\TransactionFilterDto;
use Models\Transaction;

interface TransactionRepository
{
    public function getAllPaginated(TransactionFilterDto $filter, int $page, int $limit): PaginatedArray;

    public function getById(int $id): ?Transaction;

    public function getAllByUserId(int $userId): array;

    public function getAllByUserIdPaginated(int $userId, int $page, int $limit): PaginatedArray;

    public function getAllByAccountId(int $accountId): array;

    public function getAllByAccountIdPaginated(int $accountId, int $page, int $limit): PaginatedArray;

    public function insert(CreateTransactionDto $transaction): bool;
}