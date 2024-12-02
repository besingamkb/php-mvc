<?php

require_once __DIR__ . '/config/config.php';
require_once 'vendor/autoload.php';

use App\Console\Commands\ImportXML;
use App\Console\CommandServiceContainer;
use App\Console\Commands\GenerateFakeXML;

$command = new CommandServiceContainer();
$command->register('generate-fake-xml', GenerateFakeXML::class);
$command->register('import-xml', ImportXML::class);
$command->handle();