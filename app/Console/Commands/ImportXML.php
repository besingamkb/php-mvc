<?php

namespace App\Console\Commands;

use App\Models\Author;

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
//            $this->dump($array);

            $authorModel = new Author();
            foreach ($array as $items) {
                foreach ($items as $book) {
                    $this->info("Book: " . $book['name'] . " Author: " . $book['author']);
                    $authorModel->insert([
                        'name' => $book['author']
                    ]);
                }
            }
        } else {
            $this->error("File not found");
        }
    }
}