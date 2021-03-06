<?php

namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Database
{

    private $conn;

    private static $instance;

    private function __construct()
    {
        $db_options = (require __DIR__ . '/../../settings.php')['db'];

        try {

        $this->conn = new \PDO('mysql:host=' . $db_options['host'] . ';dbname=' . $db_options['dbname'],
            $db_options['user'], $db_options['password']);

        $this->conn->exec('SET NAMES UTF8');
        }catch (\PDOException $e){
            throw new DbException('Error while connection to database: ' . $e->getMessage());
        }

    }

    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($params);

        if (false === $result) {
            return null;
        }

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->conn->lastInsertId();
    }
}