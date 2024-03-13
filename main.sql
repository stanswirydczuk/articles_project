-- Create database
CREATE DATABASE IF NOT EXISTS mydatabase;

-- Use the database
USE mydatabase;

-- Create table for news articles
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for news authors
CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Insert some initial authors
INSERT INTO authors (name) VALUES ('John Doe'), ('Jane Smith'), ('Alice Johnson');
