<?php

namespace App\Console\Commands;

interface Command
{
    public function handle(): void;
}