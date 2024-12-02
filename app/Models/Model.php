<?php

namespace App\Models;

use PDO;
use PDOException;

class Model
{
    private PDO $db;

    protected string $table;
    public function __construct()
    {
        $this->db = new PDO(
            sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                env('DB_HOST', 'localhost'),
                env('DB_PORT', '5432'),
                env('DB_NAME', 'testdb')
            ),
            env('DB_USER', 'testuser'),
            env('DB_PASSWORD', 'password'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function getDb(): PDO
    {
        return $this->db;
    }


    public function getAll(): array
    {
        $query = "SELECT * FROM $this->table";
        $statement = $this->getDb()->query($query);

        return $statement->fetchAll();
    }

    public function insert(array $data): bool
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";

            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Insert Error: " . $e->getMessage();
            return false;
        }
    }
}