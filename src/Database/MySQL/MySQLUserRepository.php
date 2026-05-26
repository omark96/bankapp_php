<?php

namespace Database\MySQL;

use Core\Database;
use Core\Types\PaginatedArray;
use Database\DTOs\UpdateUserDto;
use Database\Interfaces\UserRepository;
use Exception;
use Models\User;

class MySQLUserRepository implements UserRepository
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

    public function getAllPaginated(int $page, int $limit)
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
        } catch (Exception) {
            return null;
        }
        
        return $this->getById($userDto->id);
    }
}