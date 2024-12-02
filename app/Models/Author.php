<?php

namespace App\Models;

use PDO;

class Author extends Model
{
    protected string $table = 'authors';

    public function getBooksWithAuthors($search = null, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "
            SELECT
                *
            FROM
                authors
                INNER JOIN
                books ON authors.id = books.author_id
            WHERE
                (authors.name ILIKE '%' || COALESCE(:search, '') || '%'
                OR books.title ILIKE '%' || COALESCE(:search, '') || '%')
            ORDER BY
                authors.name, books.title
            LIMIT :limit OFFSET :offset;
        ";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(':search', $search);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $totalResults = $this->getTotalCount($search);

        return [
            'data' => $results,
            'total' => $totalResults,
            'total_pages' => ceil($totalResults / $perPage),
            'current_page' => $page,
        ];
    }

    private function getTotalCount($search = null)
    {
        $sql = "
            SELECT COUNT(*) 
            FROM authors
            INNER JOIN books ON authors.id = books.author_id
            WHERE
                (authors.name ILIKE '%' || COALESCE(:search, '') || '%'
                OR books.title ILIKE '%' || COALESCE(:search, '') || '%');
        ";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(':search', $search);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}