<?php

namespace App\Controllers;

use App\Models\Author;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $authorsModel = new Author();

        $this->render('home', [
            'users' => $authorsModel->getAll(),
        ]);
    }
}