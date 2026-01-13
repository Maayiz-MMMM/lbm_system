<?php

require_once 'BaseModel.php';

class Book extends BaseModel
{
    private $title;
    private $author;
    private $category;
    private $cover_image;
    private $available_qty;
    private $total_qty;
    private $isbn;
    private $is_active;

    function getTableName()
    {
        return 'books';
    }

    protected function addNewRec()
    {
        $param = array(
            ':title' => $this->title,
            ':author' => $this->author,
            ':category' => $this->category,
            ':cover_image' => $this->cover_image,
            ':total_qty' => $this->total_qty,
             ':available_qty' => $this->available_qty,
            ':isbn' => $this->isbn
        );

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(title, author, category, cover_image,total_qty,available_qty,isbn) values(:title, :author, :category, :cover_image,:total_qty,:available_qty,:isbn)", $param);
    }

    public function decreaseAvailableQty($book_id, $qty)
{

    $param = array(
           ':qty' => $qty,
           ':id'  => $book_id
              );
    return $this->pm->run("
        UPDATE books 
        SET available_qty = available_qty - :qty
        WHERE id = :id", $param);
}

public function increase_available_book($book_id, $qty)
{
    $param = [
        ':book_id' => $book_id,
        ':qty'     => $qty
    ];

    return $this->pm->run("
        UPDATE books
        SET available_qty = LEAST(available_qty + :qty, total_qty)
        WHERE id = :book_id
    ", $param);
}

   protected function updateRec()
{
    if ($this->getBookByIsbnExceptId($this->isbn, $this->id)) {
        return false;
    }

    $param = [
        ':title'       => $this->title,
        ':is_active' => $this->is_active,
        ':author'      => $this->author,
        ':category'    => $this->category,
        ':cover_image' => $this->cover_image,
        ':total_qty'   => $this->total_qty,
        ':available_qty' => $this->available_qty,
        ':isbn'        => $this->isbn,
        ':id'          => $this->id
    ];

    return $this->pm->run(
        "UPDATE books SET
            title = :title,
            author = :author,
            category = :category,
            cover_image = :cover_image,
            total_qty = :total_qty,
            available_qty = :available_qty,
            is_active = :is_active,
            isbn = :isbn
         WHERE id = :id",
        $param
    );
}
public function saveCall ($title,$author,$category,$imageFileName,$available_qty,$total_qty,$isbn,$is_active,$id) {

    $this->id     = $id;
        $this->title         = $title;
        $this->author        = $author;
        $this->category      = $category;
        $this->cover_image   = $imageFileName;
        $this->available_qty = $available_qty;
        $this->total_qty     = $total_qty;
        $this->isbn          = $isbn;
        $this->is_active     = $is_active;
     $result = $this->save();
     if ($result ){
        return true;
     } else {
        return false;
     }

}

    public function getBookByTitle($title, $author, $bookId = null)
{
    $param = [
        ':title' => $title,
        ':author' => $author
    ];

    $query = "SELECT * FROM " . $this->getTableName() . " 
              WHERE title = :title or author = :author";

    if ($bookId !== null) {
        $query .= " AND id != :bookId";
        $param[':bookId'] = $bookId;
    }

    $result = $this->pm->run($query, $param);

    return $result;
}

    function add_new_book($title, $author, $category, $cover_image, $total_qty,$available_qty,$isbn)
    {
        $book = new Book();
      
        $existingBook = $book->getBookByTitle($title, $author);

        if ($existingBook) {
           
            return false; 
        }

        $book = new Book();
        $book->title = $title;
        $book->author = $author;
        $book->category = $category;
        $book->cover_image = $cover_image;
        $book->total_qty = $total_qty;
        $book->available_qty = $available_qty;
        $book->isbn = $isbn;
        $book->addNewRec();

        if ($book) {
            return $book; 
        } else {
            return false; 
        }
    }

   
public function setId($id) {
    $this->id = $id;
}
 
  public function getBookUseBookId($id)
{
    $param = array(':id' => $id);

    return $this->pm->run("
        SELECT available_qty, total_qty 
        FROM " . $this->getTableName() . " 
        WHERE id = :id
    ", $param, true);
}

public function searchBooks($input = '', $searchBy = 'title', $category = '')
{
    $sql = "SELECT * FROM books WHERE 1=1";
    $params = [];

    if (trim($input) !== '') {
        if ($searchBy === 'author') {
            $sql .= " AND author LIKE ?";
        } else {
            $sql .= " AND title LIKE ?";
        }
        $params[] = '%' . $input . '%';
    }
    if ($category !== '') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }

    $sql .= " ORDER BY id DESC";

    return $this->pm->run($sql, $params);
}

public function getBookByIsbnExceptId($isbn, $id)
{
    $param = [
        ':isbn' => $isbn,
        ':id'   => $id
    ];

    $sql = "SELECT id FROM books WHERE isbn = :isbn AND id != :id";
    $result = $this->pm->run($sql, $param);

    return !empty($result);
}

public function deleteRec($id)
    {
        $param = array(':id' => $id);
        return $this->pm->run("DELETE FROM " . $this->getTableName() . " WHERE id = :id", $param);
    }


    public function getCategories()
    {
        $sql = "SELECT DISTINCT category FROM " . $this->getTableName() . " ORDER BY category ASC";
        return $this->pm->run($sql);
    }

    
}
