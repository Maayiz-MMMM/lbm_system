<?php

require_once 'BaseModel.php';

class Fine extends BaseModel
{
    private $member_id;
    private $book_id;
    private $issue_date;
    private $qty;
    private $status;
    private $isbn;

    function getTableName()
    {
        return 'fines';
    }

    protected function addNewRec()
    {    }



    public function markFineAsPaid($fine_id)
{
    $param = [
        ':id' => $fine_id
    ];

    return $this->pm->run("
        UPDATE fines
        SET status = 'paid',
            paid_at = NOW()
        WHERE id = :id
    ", $param);
}
    
  

    public function addFine($borrow_id, $member_id, $amount, $status)
{
    $param = [
        ':borrow_id' => $borrow_id,
        ':member_id' => $member_id,
        ':amount'    => $amount,
        ':status'    => $status
    ];

    return $this->pm->run("
        INSERT INTO fines (borrow_id, member_id, amount, status)
        VALUES (:borrow_id, :member_id, :amount, :status)
    ", $param);
}

    public function getAllFines()
    {
        return $this->pm->run("
            SELECT 
                f.id AS fine_id,
                b.id AS borrow_id,
                m.name AS member_name,
                b.issue_date AS issue_date,
                b.return_date AS return_date,
                b.last_date AS last_date,
                b.qty AS qty,
                bk.isbn AS book_isbn,
                bk.title AS book_title,
                f.amount AS fine_amount,
                f.status AS fine_status
                ,f.paid_at AS paid_at
            FROM fines f
            JOIN borrowings b ON f.borrow_id = b.id
            JOIN members m ON f.member_id = m.id
            JOIN books bk ON b.book_id = bk.id
            ORDER BY f.id DESC
        ");
    }

    protected function updateRec()
    {
        
    }

    
}
