CREATE DATABASE my_database;

USE my_database;

CREATE TABLE gebruikers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,  -- SHA-256 hash length is 64 characters
    score INT DEFAULT 0
);

-- Add a test user
INSERT INTO gebruikers (username, password, score)
VALUES ('testuser', SHA2('testpassword', 256), 100);
