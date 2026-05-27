<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\DTOs\CreateUserDto;
use Database\DTOs\UpdateUserDto;
use Database\DTOs\UserFilterDto;
use Database\Interfaces\UserRepository;
use Exception;
use Models\User;

readonly class MySQLUserRepository implements UserRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getByCardNumber(string $cardNumber): ?User
    {
        $user = $this->db->query('select * from users where card_number = :cardNumber', [
            'cardNumber' => $cardNumber
        ])->find();
        return User::fromDb($user);
    }

    public function getAllPaginated(UserFilterDto $filter, int $page, int $limit): PaginatedArray
    {
        $baseSql = 'SELECT * FROM users';
        $countSql = 'SELECT count(*) as sum FROM users';

        $conditions = [];
        $params = [];

        if ($filter->cardNumber !== null) {
            $conditions[] = 'card_number like :cardNumber';
            $params['cardNumber'] = '%' . $filter->cardNumber . '%';
        }

        if ($filter->name !== null) {
            $conditions[] = 'name like :name';
            $params['name'] = '%' . $filter->name . '%';
        }

        if ($filter->role !== null) {
            $conditions[] = 'role like :role';
            $params['role'] = '%' . $filter->role . '%';
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

        $users = [];
        foreach ($result as $user) {
            $users[] = User::fromDb($user);
        }

        return new PaginatedArray($users, $limit, $rowCount['sum'], $page);
    }

    public function getById(int $id): ?User
    {
        $result = $this->db
            ->query('
                select 
                    * 
                from users
                where users.id = :id
            ',
                [
                    'id' => $id
                ])
            ->find();

        return User::fromDb($result);
    }

    public function update(UpdateUserDto $userDto): ?User
    {
        try {
            $this->db
                ->query('
                update users
                set role = :role, name = :name, card_number = :cardNumber
                where users.id = :id
            ',
                    [
                        'role' => $userDto->role,
                        'name' => $userDto->name,
                        'cardNumber' => $userDto->cardNumber,
                        'id' => $userDto->id
                    ]
                );
            return $this->getById($userDto->id);
        } catch (Exception) {
            return null;
        }

    }

    public function insert(CreateUserDto $userDto): ?User
    {
        try {
            $this->db
                ->query('
                    insert into 
                        users (card_number, pin_hash, name, role)
                    values 
                        (:cardNumber, :pinHash, :name, :role)
                ',
                    [
                        'cardNumber' => $userDto->cardNumber,
                        'pinHash' => password_hash($userDto->pinCode, PASSWORD_DEFAULT),
                        'name' => $userDto->name,
                        'role' => $userDto->role
                    ]);
            $lastInserted = $this->db->lastInsertId();

            return $this->getById($lastInserted);
        } catch (Exception) {
            return null;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->db
                ->query('
                    delete from users
                    where id = :id
                ', [
                    'id' => $id
                ]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
}