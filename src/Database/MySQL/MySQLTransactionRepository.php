<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\DTOs\CreateTransactionDTO;
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

    public function getAllByUserIdPaginated(int $userId, int $page, int $limit): PaginatedArray
    {
        // TODO: Implement getAllByUserIdPaginated() method.
    }

    public function getAllByAccountId(int $accountId): array
    {
        // TODO: Implement getAllByAccountId() method.
    }

    public function getAllByAccountIdPaginated(int $accountId, int $page, int $limit): PaginatedArray
    {
        $result = $this->db
            ->query('
                select 
                    * 
                from transactions
                where from_account_id = :accountId or to_account_id = :accountId
                order by created_at desc 
                limit :limit offset :offset
                ',
                [
                    'accountId' => $accountId,
                    'limit' => $limit,
                    'offset' => ($page - 1) * $limit
                ])
            ->findAll();
        $rowCount = $this->db
            ->query('
                select 
                    count(*) as sum
                from transactions
                where from_account_id = :accountId or to_account_id = :accountId
                ', [
                'accountId' => $accountId
            ])
            ->find();
        $transactions = [];
        foreach ($result as $transaction) {
            $transactions[] = Transaction::fromDb($transaction);
        }
        return new PaginatedArray($transactions, $limit, $rowCount['sum'], $page);
    }

    public function insert(CreateTransactionDTO $transaction): bool
    {
        try {
            $this->db->query('
            insert into 
                transactions(from_account_id, to_account_id, type, amount) 
            VALUES 
                (:fromAccountId, :toAccountId, :type, :amount)
        ', [
                'fromAccountId' => $transaction->fromAccountId,
                'toAccountId' => $transaction->toAccountId,
                'type' => $transaction->type,
                'amount' => $transaction->amount
            ]);
            return true;
        } catch (\Exception) {
            return false;
        }
    }
}