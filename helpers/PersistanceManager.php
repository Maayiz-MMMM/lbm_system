<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ .'/SessionManager.php';



class PersistanceManager
{
    private $pdo; 

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);




            if (!isset($_SESSION['tables_created'])) {
                $this->createTables();
                $_SESSION['tables_created'] = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createTables()
    {
        $query_members = "CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL ,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('member','Admin') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

        $this->pdo->exec($query_members);

        $query_books = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    category VARCHAR(50),
    cover_image VARCHAR(255),
    available_qty INT DEFAULT 1,
    total_qty INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
";

        $this->pdo->exec($query_books);

           $query_borrowings = "CREATE TABLE IF NOT EXISTS borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    book_id INT NOT NULL,
    issue_date DATE NOT NULL,
    return_date DATE,
    status ENUM('borrowed','returned') DEFAULT 'borrowed',
    fine DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (member_id) REFERENCES members(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
";

        $this->pdo->exec($query_borrowings);


    }

    public function getCount($query, $param = null)
    {
        $result = $this->executeQuery($query, $param, true);
        return $result['c'];
    }

    public function run($query, $param = null, $fetchFirstRecOnly = false)
    {
        return $this->executeQuery($query, $param, $fetchFirstRecOnly);
    }

    public function insertAndGetLastRowId($query, $param = null)
    {
        return $this->executeQuery($query, $param, true, true);
    }

   private function executeQuery($query, $param = null, $fetchFirstRecOnly = false, $getLastInsertedId = false)
{
    try {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($param);

        // INSERT
        if ($getLastInsertedId) {
            return $this->pdo->lastInsertId();
        }

        // SELECT
        if (stripos(trim($query), 'select') === 0) {
            if ($fetchFirstRecOnly) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // UPDATE / DELETE / INSERT (no fetch)
        return true;

    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
}


