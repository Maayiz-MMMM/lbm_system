<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../models/book.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {

        if ($_POST['action'] === 'search_books_landing') {


            $inputVal = $_POST['inputVal'] ?? '';
            $searchBy = $_POST['searchBy'] ?? 'title';
            $category = $_POST['category'] ?? '';

            $bookModel = new Book();

            try {
                $results = $bookModel->searchBooks($inputVal, $searchBy, $category);
                echo json_encode([
                    'status' => 'success',
                    'data' => $results
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        } 

        
        if ($_POST['action'] === 'search_books_member') {


            $inputVal = $_POST['inputVal'] ?? '';
            $searchBy = $_POST['searchBy'] ?? 'title';
            $category = $_POST['category'] ?? '';

            $bookModel = new Book();

            try {
                $results = $bookModel->searchBooks($inputVal, $searchBy, $category);
                echo json_encode([
                    'status' => 'success',
                    'data' => $results
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        } 

        //action//
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
}
