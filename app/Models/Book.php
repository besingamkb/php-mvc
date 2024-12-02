<?php

namespace App\Models;

use Exception;
use PDO;

class Book extends Model
{
    protected string $table = 'books';

    public function insertBooksWithAuthors(array $books): bool
    {
        try {
            $books_json = json_encode($books, JSON_UNESCAPED_UNICODE);
            // execute stored procedure
            $stmt = $this->getDb()->prepare("select insert_books_with_authors(:book_data)");
            $stmt->bindValue(':book_data', $books_json);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Insert Error: " . $e->getMessage();
            return false;
        }
    }
}