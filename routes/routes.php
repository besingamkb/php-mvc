<?php
/** @var Router $router */

use App\Controllers\AuthorController;
use App\Core\Router;

$router->get('/', function () {
    redirect('/authors');
});
$router->get('/authors', [AuthorController::class, 'index']);
$router->get('/searchAuthor', [
    AuthorController::class,
    'search'
]);
