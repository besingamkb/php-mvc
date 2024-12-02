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
        echo "go to /authors";
    }
}