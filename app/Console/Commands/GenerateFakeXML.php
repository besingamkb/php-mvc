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

        for ($i = 0; $i <100; $i++) {
            $faker = $this->getRandomFaker($fakers);

            $book = [
                'name' => $faker->name,
                'author' => $faker->name,
            ];

            $books[] = $book;
        }

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><books/>');
        $this->arrayToXmlFormat($books, $xml);
        $xml->asXML('books.xml');
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