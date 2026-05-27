<?php

namespace Core;

use PDO;

class Database
{
    private PDO $connection;
    private $statement;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->connection = new PDO($dsn, $config['user'], $config['password'],
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    }

    public function query($query, $params = []): Database
    {
        $this->statement = $this->connection->prepare($query);

        foreach ($params as $key => $value) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR
            };
            $this->statement->bindValue(
                is_int($key) ? $key + 1 : $key,
                $value,
                $type
            );
        }

        $this->statement->execute();

        return $this;
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort();
        }
        return $result;
    }

    public function findAll()
    {
        return $this->statement->fetchAll();
    }

    public function execute($query): false|int
    {
        return $this->connection->exec($query);
    }

    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
