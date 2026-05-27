<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\DTOs\CreateTransactionDto;
use Database\DTOs\TransactionFilterDto;
use Database\Interfaces\TransactionRepository;
use Models\Transaction;

class MySQLTransactionRepository implements TransactionRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getAllPaginated(TransactionFilterDto $filter, int $page, int $limit): PaginatedArray
    {
        $baseSql = 'SELECT * FROM transactions';
        $countSql = 'SELECT count(*) as sum FROM transactions';

        $conditions = [];
        $params = [];

        if ($filter->startDate !== null) {
            $conditions[] = 'created_at >= :startDate';
            $params['startDate'] = $filter->startDate;
        }

        if ($filter->endDate !== null) {
            $conditions[] = 'created_at <= :endDate';
            $params['endDate'] = $filter->endDate;
        }

        if ($filter->type !== null) {
            $conditions[] = 'type = :type';
            $params['type'] = $filter->type;
        }

        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

        $rowCount = $this->db
            ->query($countSql . $whereClause, $params)
            ->find();

        $dataSql = $baseSql . $whereClause . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';

        $queryParams = array_merge($params, [
            'limit' => $limit,
            'offset' => ($page - 1) * $limit
        ]);

        $result = $this->db
            ->query($dataSql, $queryParams)
            ->findAll();


        $transactions = [];
        foreach ($result as $transaction) {
            $transactions[] = Transaction::fromDb($transaction);
        }

        return new PaginatedArray($transactions, $limit, $rowCount['sum'], $page);
    }

    public function getById(int $id): ?Transaction
    {
        $transaction = $this->db
            ->query('select * from transactions where id = :id')
            ->find();
        return Transaction::fromDb($transaction);
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

    public function insert(CreateTransactionDto $transaction): bool
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