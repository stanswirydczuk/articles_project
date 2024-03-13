CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);  

CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

ALTER TABLE articles
ADD COLUMN author_id INT;
ADD CONSTRAINT fk_author_id
FOREIGN KEY (author_id)
REFERENCES authors(id)
ON DELETE CASCADE;

INSERT INTO authors (name) VALUES ('John Doe'), ('Jane Smith'), ('David Johnson');

INSERT INTO articles (author_id, title, text, creation_date)
VALUES
    ((SELECT id FROM authors WHERE name = 'John Doe'), 'The Art of Cooking', 'Cooking is not just about mixing ingredients; it\'s about creating art. Explore the culinary world and discover the magic of flavors.', DATE_SUB(DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 7) DAY), INTERVAL 1 DAY)),
    ((SELECT id FROM authors WHERE name = 'Jane Smith'), 'Exploring the Wilderness', 'Embark on an adventure into the wilderness, where nature reveals its beauty and mysteries. Get lost in the enchanting landscapes and experience the thrill of exploration.', DATE_SUB(DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 7) DAY), INTERVAL 1 DAY)),
    ((SELECT id FROM authors WHERE name = 'David Johnson'), 'The Power of Meditation', 'Discover inner peace and tranquility through the practice of meditation. Learn to quiet the mind, reduce stress, and cultivate mindfulness for a happier and healthier life.', DATE_SUB(DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 7) DAY), INTERVAL 1 DAY));


