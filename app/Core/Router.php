<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($route, $controllerMethod)
    {
        $this->routes['GET'][$route] = $controllerMethod;
    }

    public function handleRequest($uri, $method): void
    {
        $uriParts = explode('?', $uri);
        $path = $uriParts[0];
        $query = $uriParts[1] ?? '';

        if (isset($this->routes[$method][$path])) {
            $controllerMethod = $this->routes[$method][$path];
            $params = [];
            if (!empty($query)) {
                parse_str($query, $params); // query string to params
            }

            if (is_callable($controllerMethod)) {
                // clousure here or unamed function
                call_user_func_array($controllerMethod, $params);
            } else {

                // execute controller
                list($controller, $method) = $controllerMethod;
                call_user_func_array([new $controller, $method], $params);
            }
        } else {
            echo "404 Not Found";
        }
    }
}