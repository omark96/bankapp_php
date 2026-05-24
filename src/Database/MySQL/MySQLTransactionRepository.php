<?php

namespace Database\MySQL;

use Core\Database;
use Database\Interfaces\TransactionRepository;
use Models\Transaction;

class MySQLTransactionRepository implements TransactionRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getAllPaginated(int $page, int $limit): array
    {
        // TODO: Implement getAllPaginated() method.
    }

    public function getById(int $id): ?Transaction
    {
        $transaction = $this->db
            ->query('select * from transactions where id = :id')
            ->find();
        return Transaction::fromDb($transaction);
    }

    public function getAllByUserId(int $userId): array
    {
        // TODO: Implement getAllByUserId() method.
    }

    public function getAllByUserIdPaginated(int $userId, int $page, int $limit): array
    {
        // TODO: Implement getAllByUserIdPaginated() method.
    }

    public function getAllByAccountId(int $accountId): array
    {
        // TODO: Implement getAllByAccountId() method.
    }

    public function getAllByAccountIdPaginated(int $accountId, int $page, int $limit): array
    {
        // TODO: Implement getAllByAccountIdPaginated() method.
    }

    public function insert(Transaction $transaction): bool
    {
        // TODO: Implement insert() method.
    }
}