
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    profile_image VARCHAR(255),
    role ENUM('member','admin') DEFAULT 'member',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;



CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    isbn VARCHAR(20) UNIQUE NOT NULL,
    cover_image VARCHAR(255),
    total_qty INT DEFAULT 1,
    available_qty INT DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;



CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    book_id INT NOT NULL,
    issue_date DATE NOT NULL,
    last_date DATE,
    return_date DATE,
    qty INT DEFAULT 1,
    status ENUM('borrowed','returned') DEFAULT 'borrowed',
    fine DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (member_id) REFERENCES members(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
) ENGINE=InnoDB;



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
) ENGINE=InnoDB;



INSERT INTO members (name, email, password, phone, role)
VALUES (
    'Admin User',
    'admin@example.com',
    '$2y$10$rS57x0GxJlFPdU3vxWMnpO65gBHpHbMeTyAU2sMEQwxrfoE3jQTxC',
    '0756481382',
    'admin'
);



INSERT INTO categories (name) VALUES
('Fiction'),
('Crime'),
('Classic'),
('Science Fiction'),
('Adventure'),
('American Literature');
