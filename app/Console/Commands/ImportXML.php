<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;

class ImportXML implements Command
{
    use CanPrint;

    public function handle(): void
    {
        $path = "books.xml";

        if (file_exists($path)) {
            $xml = simplexml_load_file($path);
            $json = json_encode($xml);
            $array = json_decode($json, true);

            $book = [];
            foreach ($array['book'] as $item) {
                $book[] = [
                    'title' => mb_convert_encoding($item['name'], 'UTF-8', 'auto'),
                    'author' => mb_convert_encoding($item['author'], 'UTF-8', 'auto')
                ];
            }

            $bookModel = new Book();
            $a = $bookModel->insertBooksWithAuthors($book);
            $this->dump($a);
        } else {
            $this->error("File not found");
        }
    }
}