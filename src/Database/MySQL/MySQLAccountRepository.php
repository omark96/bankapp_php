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
        $result = $this->db
            ->query('
                select 
                    A.*,
                    coalesce(incoming.sum, 0) as incoming,
                    coalesce(outgoing.sum, 0) as outgoing
                from accounts as A
                left join (
                    select
                        to_account_id,
                        sum(amount) as sum
                    from transactions
                    group by to_account_id
                ) as incoming on A.id = incoming.to_account_id
                left join (
                    select
                        from_account_id,
                        sum(amount) as sum
                    from transactions
                    group by from_account_id
                ) as outgoing on A.id = outgoing.from_account_id
                order by A.created_at desc
                limit :limit offset :offset;
                ',
                [
                    'limit' => $limit,
                    'offset' => ($page - 1) * $limit
                ])
            ->findAll();

        $rowCount = $this->db
            ->query('
                select 
                    count(*) as sum
                from accounts
                ')
            ->find();

        $accounts = [];
        foreach ($result as $account) {
            $accounts[] = Account::fromDb($account);
        }

        return new PaginatedArray($accounts, $limit, $rowCount['sum'], $page);
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