<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

try {

    $router = new Router();

    // definition of routes
    require_once __DIR__ . '/../routes/routes.php';

    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    $router->handleRequest($uri, $method);
} catch (Throwable $e) {
    echo $e->getMessage();
    print_r($e->getTrace());
}
