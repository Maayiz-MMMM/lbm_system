<?php

require_once 'BaseModel.php';

class Borrowing extends BaseModel
{
    private $member_id;
    private $book_id;
    private $issue_date;
    private $qty;
    private $status;
    private $isbn;

    function getTableName()
    {
        return 'borrowings';
    }

    protected function addNewRec()
    {
        $param = array(
            ':member_id' => $this->member_id,
            ':book_id' => $this->book_id,
            ':issue_date' => $this->issue_date,
            ':qty' => $this->qty,
            ':status' => $this->status,
            ':isbn' => $this->isbn
        );

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(member_id, book_id, issue_date, qty, status, isbn) values(:member_id, :book_id, :issue_date, :qty, :status, :isbn)", $param);
    }


     public function getAllBorrowings()
    {
        return $this->pm->run("
            SELECT 
                b.id AS borrow_id,
                m.name AS member_name,
                bk.title,
                bk.isbn as isbn,
                b.issue_date as issue_date,
                b.return_date as return_date,
                b.last_date as last_date,
                b.qty as qty,
                b.status as status,
                b.fine as fine,
                f.amount as fine_amount,
                f.status as fine_status

            FROM borrowings b
            JOIN members m ON b.member_id = m.id
            JOIN books bk ON b.book_id = bk.id
            LEFT JOIN fines f ON f.borrow_id = b.id
            ORDER BY b.id DESC
        ");
    }

public function updateBorrowingReturn($borrow_id, $return_date, $fine)
{
    $param = [
        ':borrow_id'   => $borrow_id,
        ':return_date' => $return_date,
        ':fine'        => $fine
    ];

    return $this->pm->run("
        UPDATE borrowings
        SET return_date = :return_date,
            fine = :fine,
            status = 'returned'
        WHERE id = :borrow_id
    ", $param);
}
   

    public function getBorrowingsWithMembersAndBooksByborrowID($borrow_id)
    {
        $param = array(':borrow_id' => $borrow_id);
        return $this->pm->run("
            SELECT 
                b.id AS borrow_id,
                m.name AS member_name,
                m.id AS member_id,
                bk.title,
                b.issue_date as issue_date,
                b.return_date as return_date,
                b.last_date as last_date,
                b.book_id as book_id,
                b.qty as qty,
                b.status as status
                
            FROM borrowings b
            JOIN members m ON b.member_id = m.id
            JOIN books bk ON b.book_id = bk.id
            WHERE b.id = :borrow_id", $param, true);
    }

    public function clearBorrowingFine($borrow_id)
{
    $param = [
        ':id' => $borrow_id
    ];

    return $this->pm->run("
        UPDATE borrowings
        SET fine = 0
        WHERE id = :id
    ", $param);
}

   protected function updateRec()
{
    $param = [
        ':id'         => $this->id,
        ':member_id'  => $this->member_id,
        ':book_id'    => $this->book_id,
        ':issue_date' => $this->issue_date,
        ':qty'        => $this->qty,
        ':status'     => $this->status
    ];

    return $this->pm->run("
        UPDATE borrowings
        SET 
            member_id  = :member_id,
            book_id    = :book_id,
            issue_date = :issue_date,
            qty        = :qty,
            status     = :status
        WHERE id = :id
    ", $param);
}




    public function add_new_borrowing($member_id, $book_id, $issue_date, $qty, $status , $last_date)
{

    $param = array(
        ':member_id' => $member_id,
        ':book_id' => $book_id,
        ':issue_date' => $issue_date,
        ':qty' => $qty,
        ':status' => $status,
        ':last_date' => $last_date
    );
    return $this->pm->run("
        INSERT INTO borrowings (member_id, book_id, issue_date, qty, status, last_date)
        VALUES (:member_id, :book_id, :issue_date, :qty, :status, :last_date)
    ", $param);
}






    public function updateBorrowing($borrow_id, $member_id, $book_id, $issue_date, $qty, $status)
{
    $bookModel = new Book();

    $current = $this->getBorrowingsWithMembersAndBooksByborrowID($borrow_id);
    if (!$current) {
        return ['status' => 'error', 'message' => 'Borrowing record not found'];
    }
    
    
    $old_book_id = $current['book_id'];
    $old_qty = $current['qty'];

    if ($book_id != $old_book_id) {
       
        $book = $bookModel->getBookUseBookId($book_id);
        if (!$book || $qty > $book['available_qty']) {
            return ['status' => 'error', 'message' => 'New book stock not sufficient'];
        }
    } else {
        $book = $bookModel->getBookUseBookId($book_id);
        if ($qty > $old_qty + $book['available_qty']) {
            return ['status' => 'error', 'message' => 'Requested quantity exceeds available stock'];
           
        }
    }

    $this->startTransaction();
    try {
        if ($book_id != $old_book_id) {
            $bookModel->increase_available_book($old_book_id, $old_qty);
            $bookModel->decreaseAvailableQty($book_id, $qty);
        } else {
       

            $diff = $qty - $old_qty;
            if ($diff > 0) {
                $bookModel->decreaseAvailableQty($book_id, $diff);
            } elseif ($diff < 0) {
                $bookModel->increase_available_book($book_id, abs($diff));
            }
        }

        $this->id = $borrow_id;
        $this->member_id = $member_id;
        $this->book_id = $book_id;
        $this->issue_date = $issue_date;
        $this->qty = $qty;
        $this->status = $status;

        $this->updateRec();
        

      
        $this->commit();
        return ['status' => 'success', 'message' => 'Borrowing updated successfully'];

    } catch (Exception $e) {
        $this->rollback();
        return ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
    }
}

public function updateBorrowingWithLastDate(
    $id,
    $member_id,
    $book_id,
    $issue_date,
    $qty,
    $status,
    $last_date
) {
    $param = [
        ':id'         => $id,
        ':member_id'  => $member_id,
        ':book_id'    => $book_id,
        ':issue_date' => $issue_date,
        ':qty'        => $qty,
        ':status'     => $status,
        ':last_date'  => $last_date
    ];

    return $this->pm->run("
        UPDATE borrowings SET
            member_id  = :member_id,
            book_id    = :book_id,
            issue_date = :issue_date,
            qty        = :qty,
            status     = :status,
            last_date  = :last_date
        WHERE id = :id
    ", $param);
}




public function bookBorrowCheck($book_id)
{
    $param = [
        ':book_id' => $book_id
    ];

    $result = $this->pm->run("
        SELECT COUNT(*) AS borrow_count
        FROM borrowings
        WHERE book_id = :book_id
    ", $param, true);

    return $result['borrow_count'] ?? 0;
    
}

   public function getBorrowedStatusMmbr($member_id){
        
        $param = ['member_id'=>$member_id];
        $query="SELECT 
    b.id,
    b.issue_date,
    b.last_date,
    b.return_date,
    b.status,
    b.fine,
    b.qty,
    bk.title AS book_name,
    m.name AS member_name
FROM borrowings b
JOIN books bk ON b.book_id = bk.id
JOIN members m ON b.member_id = m.id
WHERE 
    b.status = 'borrowed'
    AND b.member_id = :member_id;";
        return $this->pm->run($query,$param);
    }

    public function getTotalFines($member_id){
        
        $param = ['member_id'=>$member_id];
        $query="SELECT SUM(fine) AS total_fine
FROM borrowings
WHERE member_id = :member_id";
        return $this->pm->run($query,$param);
    }

    public function getBorrowDetails ($member_id){

        $param = ['member_id'=>$member_id];
        $query="SELECT * FROM borrowings WHERE member_id = :member_id;";
        return $this->pm->run($query,$param);

    }
    public function getBooksQtyByBorrowid($borrow_id){
        $param = [':id'=>$borrow_id];
 $query="SELECT qty,book_id FROM borrowings WHERE id = :id";
        return $this->pm->run($query,$param,true);
        
    }

    public function deleteRec($id)
    {
        $param = array(':id' => $id);
        return $this->pm->run("DELETE FROM " . $this->getTableName() . " WHERE id = :id", $param);
    }

}
