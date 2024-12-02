<?php

namespace App\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authorsModel = new Author();

        $this->render('authors', [
            'authors' => $authorsModel->getAll(),
        ]);
    }

    public function search($search = null, $page = 1, $perPage = 10)
    {
//        echo "search: " . $search . "<br>";
//        echo "current page: " . $page . "<br>";
//        echo "per page: " . $perPage . "<br>";
//        die();
        $response = (new Author())->getBooksWithAuthors($search, $page, $perPage);
        $responseData = [
            'status' => 'success',
            'data' => $response['data'],
            'pagination' => [
                'total' => $response['total'],
                'total_pages' => $response['total_pages'],
                'current_page' => $response['current_page'],
                'per_page' => $perPage
            ]
        ];

//        header('Content-Type: application/json');
//        http_response_code(200);
//        echo json_encode($responseData);

        responseJson($responseData, 200);
    }
}