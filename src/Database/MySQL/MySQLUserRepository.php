<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\DTOs\CreateUserDto;
use Database\DTOs\UpdateUserDto;
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

    public function getAllPaginated(int $page, int $limit): PaginatedArray
    {
        $result = $this->db
            ->query('
                select 
                    * 
                from users as U
                order by U.created_at desc
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
            from users
            ')
            ->find();

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