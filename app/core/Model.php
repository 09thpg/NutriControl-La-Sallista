<?php

require_once MODEL_PATH . '/Database.php';

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    protected function query(string $sql): PDOStatement
    {
        return $this->db->query($sql);
    }

    protected function prepare(string $sql): PDOStatement
    {
        return $this->db->prepare($sql);
    }

    protected function fetch(PDOStatement $stmt): array|false
    {
        return $stmt->fetch();
    }

    protected function fetchAll(PDOStatement $stmt): array
    {
        return $stmt->fetchAll();
    }

    protected function execute(PDOStatement $stmt, array $params = []): bool
    {
        return $stmt->execute($params);
    }

    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}