CREATE DATABASE library;
USE library;

CREATE TABLE admins(
id INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(100),
last_name VARCHAR(100),
username VARCHAR(100) UNIQUE,
password VARCHAR(255),
email VARCHAR(100) UNIQUE,
phone VARCHAR(20),
image VARCHAR(255),
reset_token VARCHAR(255) DEFAULT NULL,
token_expiry DATETIME DEFAULT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students(
id INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(100),
last_name VARCHAR(100),
username VARCHAR(100) UNIQUE,
password VARCHAR(255),
roll_no VARCHAR(50),
email VARCHAR(100) UNIQUE,
phone VARCHAR(20),
image VARCHAR(255),
reset_token VARCHAR(255) DEFAULT NULL,
token_expiry DATETIME DEFAULT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books(
id INT AUTO_INCREMENT PRIMARY KEY,
book_name VARCHAR(150),
authors VARCHAR(200),
edition VARCHAR(50),
department VARCHAR(100),
quantity INT DEFAULT 0,
available INT DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE book_requests(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
book_id INT,
status ENUM(
'pending',
'approved',
'rejected'
) DEFAULT 'pending',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY(student_id)
REFERENCES students(id),
FOREIGN KEY(book_id)
REFERENCES books(id)
);

CREATE TABLE issue_books(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
book_id INT,
issue_date DATE,
expected_return_date DATE,
return_date DATE,
status ENUM(
'issued',
'returned'
) DEFAULT 'issued',
FOREIGN KEY(student_id)
REFERENCES students(id),
FOREIGN KEY(book_id)
REFERENCES books(id)
);

CREATE TABLE fines(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
book_id INT,
late_days INT,
amount DECIMAL(10,2),
status ENUM(
'unpaid',
'paid'
) DEFAULT 'unpaid',
FOREIGN KEY(student_id)
REFERENCES students(id),
FOREIGN KEY(book_id)
REFERENCES books(id)
);

CREATE TABLE comments(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
message TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY(student_id)
REFERENCES students(id)
);