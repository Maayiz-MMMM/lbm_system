<?php

require_once 'BaseModel.php';

class User extends BaseModel
{
    private $name;
    private $role;
    private $email;
    private $phone;
    private $password;
    private $profile_image;
    private $is_active;

    function getTableName()
    {
        return 'members';
    }

    protected function addNewRec()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $param = array(
            ':name' => $this->name,
            ':password' => $this->password,
            ':role' => $this->role,
            ':email' => $this->email,
            ':phone' => $this->phone,
            ':profile_image' => $this->profile_image,
        );

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(name, password,role,email,phone,profile_image) values(:name, :password,:role,:email,:phone,:profile_image)", $param);
    }

    public function getByEmail($email)
    {
        $param = array(':email' => $email);
        return $this->pm->run("
            SELECT * FROM " . $this->getTableName() . " 
            WHERE email = :email
        ", $param);
    }

    protected function updateRec()
{
    $existingUser = $this->getUserBynameOrEmailWithId(
        $this->name,
        $this->email,
        $this->id
    );

    if ($existingUser) {
        return false;
    }

    $oldUser = $this->getById($this->id);

    if (!empty($this->password)) {
        $password = password_hash($this->password, PASSWORD_DEFAULT);
    } else {
        $password = $oldUser['password']; 
    }

    if (!empty($this->profile_image)) {
        $profile_image = $this->profile_image;
    } else {
        $profile_image = $oldUser['profile_image']; 
    }

    $param = [
        ':name'          => $this->name,
        ':password'      => $password,
        ':role'          => $this->role,
        ':email'         => $this->email,
        ':phone'         => $this->phone,
        ':profile_image' => $profile_image,
        ':is_active'  =>$this->is_active,
        ':id'            => $this->id
    ];

    return $this->pm->run(
        "UPDATE " . $this->getTableName() . " SET
            name = :name,
            password = :password,
            role = :role,
            email = :email,
            phone = :phone,
            profile_image = :profile_image,
            is_active = :is_active
         WHERE id = :id",
        $param
    );
}


    public function getUserBynameOrEmailWithId($name, $email, $excludeUserId = null)
    {
        $param = array(':name' => $name, ':email' => $email);

        $query = "SELECT * FROM " . $this->getTableName() . " 
                  WHERE (name = :name OR email = :email)";

        if ($excludeUserId !== null) {
            $query .= " AND id != :excludeUserId";
            $param[':excludeUserId'] = $excludeUserId;
        }

        $result = $this->pm->run($query, $param);

        return $result; 
    }

    public function getUserBynameOrEmail($name, $email)
    {
        $email = strtolower($email);
        $param = array(
            ':name' => $name,
            ':email' => $email
        );

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE name = :name OR email = :email";
        $result = $this->pm->run($sql, $param);
        if (!empty($result)) {  
            $user = $result[0];
            return $user;
        } else {
            return null;
        }
    }


    function add_new_user($name, $password, $role, $email, $phone,$profile_image_name)
    {
        $user = new User();
        $existingUser = $user->getUserBynameOrEmail($name, $email);
     
        if ($existingUser) {
           
            return false; 
        }

        $user = new User();
        $user->name = $name;
        $user->password = $password;
        $user->role = $role;
        $user->email = strtolower($email);
        $user->phone = $phone;
        $user->profile_image = $profile_image_name;
        $user->addNewRec();

        if ($user) {
            return true; 
        } else {
            return false; 
        }
    }

    function updateUser($id, $name, $password, $role, $email, $phone,$profile_image_name,$is_active)
    {
        $userModel = new User();

        $existingUser = $userModel->getUserBynameOrEmailWithId($name, $email, $id);
        if ($existingUser) {
            return false; 
        }

        
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
        $this->profile_image = $profile_image_name;
        $this->phone = $phone;
        $this->is_active = $is_active;
       $user= $this->updateRec();

        if ($user) {
            return true; 
        } else {
            return false; 
        }
    }

    function deleteUser($id)
    {
        $user = new User();
        $user->deleteRec($id);

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastInsertedUserId()
    {
        $result = $this->pm->run('SELECT MAX(id) as lastInsertedId FROM users', null, true);
        return $result['lastInsertedId'] ?? 100;
    }

public function getBorrowedBooks($member_id)
{
    $param = [$member_id];

    return $this->pm->run(
        "SELECT 
            b.title AS title,
            b.isbn AS isbn,
            b.total_qty AS qty,
            br.issue_date AS issue_date,
            br.last_date AS last_date,
            br.return_date AS return_date,
            br.status AS status,
            br.fine AS fine,
            f.amount AS fine_amount,
            f.status AS fine_status,
            f.paid_at AS fine_paid_at
        FROM borrowings br
        JOIN books b ON br.book_id = b.id
        LEFT JOIN fines f ON f.borrow_id = br.id
        WHERE br.member_id = ?",
        $param
    );
}

    public function getFines($member_id)
    {
        $param = [$member_id];
        return $this->pm->run(
            "SELECT f.amount as fine_amount, f.status as fine_status, f.paid_at as fine_paid_at, b.isbn as book_isbn
             FROM fines f
             JOIN borrowings br ON f.borrow_id = br.id
             JOIN books b ON br.book_id = b.id
             WHERE f.member_id = ?",
            $param
        );
    }

    public function getMemberById($id)
    {
        return $this->pm->run(
            "SELECT * FROM " . $this->getTableName() . " WHERE id = ?",
            [$id],
            true
        );
    }

    public function startTransaction()
    {
        return $this->pm->run("START TRANSACTION");
    }

    public function commit()
    {
        return $this->pm->run("COMMIT");
    }

    public function rollback()
    {
        return $this->pm->run("ROLLBACK");
    }
}
