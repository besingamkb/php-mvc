<?php

namespace App\Models;

class Author extends Model
{
    protected string $table = 'authors';

    public function all(): array
    {
        $stmt = $this->getDb()->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }
}