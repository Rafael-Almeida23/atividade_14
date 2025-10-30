CREATE DATABASE IF NOT EXISTS kanban_db;
USE kanban_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    CHECK (email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')
);

CREATE TABLE kanban (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kanban_id INT NOT NULL,
    description TEXT NOT NULL,
    sector VARCHAR(255) NOT NULL,
    priority ENUM('low', 'medium', 'high') NOT NULL,
    user_id INT NOT NULL,
    status ENUM('to_do', 'doing', 'done') NOT NULL,
    FOREIGN KEY (kanban_id) REFERENCES kanban(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
