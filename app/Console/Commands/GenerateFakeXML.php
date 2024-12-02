<?php

namespace App\Console\Commands;

use Faker\Factory;
use SimpleXMLElement;

class GenerateFakeXML implements Command
{
    use CanPrint;
    public function handle(): void
    {
        $this->info("Generating fake XML");
        $fakerEnglish = Factory::create('en_US');
        $fakerCyrillic = Factory::create('ru_RU');
        $fakerKorean = Factory::create('ko_KR');
        $fakerJapanese = Factory::create('ja_JP');
        $fakers = [$fakerEnglish, $fakerCyrillic, $fakerKorean, $fakerJapanese];

        $books = [];

        for ($i = 0; $i < 3000; $i++) {
            $faker = $this->getRandomFaker($fakers);

            $book = [
                'name' => $i % 3 == 0 ? $faker->name : $faker->words(rand(2, 6), true),
                'author' => $faker->name,
            ];

            $books[] = $book;
        }

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><books/>');
        $this->arrayToXmlFormat($books, $xml);
        $xml->asXML('books.xml');
        $this->info("waiting for 30 seconds to make sure that files done generating books");
        sleep(30);
        $this->info("done...");
    }

    private function getRandomFaker($fakers) {
        return $fakers[array_rand($fakers)];
    }

    private function arrayToXmlFormat(array $data, SimpleXMLElement $xmlElement): void
    {
        foreach ($data as $item) {
            $bookNode = $xmlElement->addChild('book');
            foreach ($item as $key => $value) {
                $bookNode->addChild($key, htmlspecialchars($value));
            }
        }
    }
}