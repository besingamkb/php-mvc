<?php

namespace App\Controllers;

/**
 * Class Controller
 * @package App\Controllers
 */
abstract class Controller
{
    /**
     * @param string $view
     * @param array $data
     * @return void
     */
    protected function render(string $view, array $data= []): void
    {
        extract($data);
        require_once __DIR__ . "/../Views/layout.php";
    }
}