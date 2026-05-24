<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\Interfaces\AccountRepository;
use Models\Account;

class MySQLAccountRepository implements AccountRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getAllPaginated(int $page, int $limit): PaginatedArray
    {
        // TODO: Implement getAllPaginated() method.
    }

    public function getById(int $id): ?Account
    {
        $result = $this->db
            ->query('
                select
                    A.*,
                    sum(case when T.to_account_id = A.id then T.amount else 0 end) as incoming,
                    sum(case when T.from_account_id = A.id then T.amount else 0 end) as outgoing
                from accounts as A
                left join transactions T
                on A.id = T.from_account_id or A.id = T.to_account_id
                where A.id = :id
                group by A.id;
                ',
                [
                    'id' => $id
                ])->find();
        return Account::fromDb($result);
    }

    public function getAllByUserId(int $userId): array
    {
        $result = $this->db
            ->query('
                    select
                        A.*,
                        sum(case when T.to_account_id = A.id then T.amount else 0 end) as incoming,
                        sum(case when T.from_account_id = A.id then T.amount else 0 end) as outgoing
                    from accounts as A
                    left join transactions T
                    on A.id = T.from_account_id or A.id = T.to_account_id
                    where user_id = :userId
                    group by A.id;
                    ',
                [
                    'userId' => $userId
                ]
            )->findAll();
        $accounts = [];

        foreach ($result as $account) {
            $accounts[] = Account::fromDb($account);
        }
        return $accounts;
    }

    public function insert(Account $account): bool
    {
        // TODO: Implement insert() method.
    }
}