<?php

namespace App\Console\Commands;

trait CanPrint
{
    public function info(string $message): void
    {
        echo "info: " . $message . "\n";
    }

    public function error(string $message): void
    {
        echo "error: " . $message . "\n";
    }

    public function dump(string | object | array $data): void
    {
        echo "dump: \n";
        print_r($data);
    }
}