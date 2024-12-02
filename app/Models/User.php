<?php

namespace App\Models;

class User extends Model
{
    protected $table = "users";
    public function getAll(): array
    {
        $query = "SELECT id, name FROM {$this->table}";
        $statement = $this->getDb()->query($query);

        return $statement->fetchAll();
    }
}