<?php

namespace Core;

use PDO;

class Database
{
    private PDO $connection;
    private $statement;

    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = []): Database
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

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

    public function execute($query)
    {
        return $this->connection->exec($query);
    }
}
