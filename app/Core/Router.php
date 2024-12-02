<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $path, callable|array $action): void
    {
        $this->routes[$path] = $action;
    }

    public function dispatch(string $path): void
    {
        $action = $this->routes[$path] ?? null;

        if (!$action) {
            http_response_code(404);
            echo "404 - Not Found";
            return;
        }

        if (is_callable($action)) {
            call_user_func($action);
        } else {
            $controller = new $action[0];
            $method = $action[1];
            $controller->$method();
        }
    }
}