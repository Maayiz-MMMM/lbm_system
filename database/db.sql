CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL ,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('member','Admin') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    category VARCHAR(50),
    isbn VARCHAR(20) UNIQUE NOT NULL,
    cover_image VARCHAR(255),
    available_qty INT DEFAULT 1,
    total_qty INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS borrowings (
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

ALTER TABLE borrowings
ADD COLUMN qty INT DEFAULT 1;
ALTER TABLE borrowings
ADD COLUMN last_date DATE AFTER issue_date;

CREATE TABLE fines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    borrow_id INT NOT NULL,
    member_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    status ENUM('nothing','pending','paid') DEFAULT 'nothing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paid_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (borrow_id) REFERENCES borrowings(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

INSERT INTO members (name,email,password,phone,role) VALUES ('Admin User','admin@example.com','$2y$10$rS57x0GxJlFPdU3vxWMnpO65gBHpHbMeTyAU2sMEQwxrfoE3jQTxC','0756481382','admin')


ALTER TABLE members 
ADD COLUMN profile_image VARCHAR(255) NULL AFTER phone;

ALTER TABLE books
ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1
AFTER total_qty;

ALTER TABLE members
ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1
AFTER profile_image;


