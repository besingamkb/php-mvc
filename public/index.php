<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Core\Router;

try {

    $router = new Router();
    $router->add('/', [HomeController::class, 'index']);

    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $router->dispatch($path);

} catch (Throwable $e) {
    echo $e->getMessage();
}
