<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../models/book.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['action'])&&$_POST['action'] === 'search_books') { 

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

exit;
} else {echo json_encode([
        'status' => 'error',
        'message' => 'invalid action'
    ]);}