<?php

namespace App\Console;

class CommandServiceContainer
{
    protected array $commands = [];

    public function register($command, $class): void
    {
        $this->commands[$command] = $class;
    }

    public function handle(): void
    {
        global $argv;
        $command = $argv[1] ?? null;

        if (isset($this->commands[$command])) {
            $command = new $this->commands[$command];
            $command->handle();
        } else {
            echo "Command not found\n";
        }
    }
}