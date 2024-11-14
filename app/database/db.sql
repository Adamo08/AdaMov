CREATE DATABASE IF NOT EXISTS movies_db;
USE movies_db;

-- Creating tables

--
-- Users table
-- The users table will include fields for registration, email verification, and user details.
--

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status BOOLEAN DEFAULT FALSE, -- Email verification status
    verification_token VARCHAR(255) NULL, -- Token for email verification
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


--
-- Genres table
-- The genres table stores the genres of media (movies, shows, etc.).
--

CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


--
-- Media table
-- The media table stores information about movies, shows, or any media content.
--

CREATE TABLE IF NOT EXISTS media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_date DATE,
    genre_id INT,
    comments_count INT DEFAULT 0,
    views_count INT DEFAULT 0,
    thumbnail VARCHAR(255),     -- URL or path to the media thumbnail image
    file_name VARCHAR(255),     -- Name of the media file
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES genres(id)
);



--
-- Comments table
-- The comments table allows users to leave comments on media.
--

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    media_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    parent_id INT DEFAULT NULL, -- For threaded replies
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (media_id) REFERENCES media(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (parent_id) REFERENCES comments(id) -- For replies
);


-- 
-- Reviews table
-- The reviews table stores reviews for media items.
--

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    media_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5), -- Rating from 1 to 5
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (media_id) REFERENCES media(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


-- 
-- User's social links table
-- This table stores the social links of a user.
--

CREATE TABLE IF NOT EXISTS user_social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    facebook VARCHAR(255) NULL,
    instagram VARCHAR(255) NULL,
    twitter VARCHAR(255) NULL,
    github VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


--
-- Favorites Table (Optional)
-- A table to manage user favorites (e.g., saving favorite media).
--

CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    media_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (media_id) REFERENCES media(id)
);




-- Inserting sample data for the movies_db database with SHA-256 hashed passwords

-- Inserting into users table with hashed passwords
INSERT INTO users (fname, lname, email, password, status, verification_token) 
VALUES
    ('John', 'Doe', 'john.doe@example.com', SHA2('password123', 256), TRUE, NULL),
    ('Jane', 'Smith', 'jane.smith@example.com', SHA2('securepassword', 256), FALSE, 'token123'),
    ('Alice', 'Johnson', 'alice.johnson@example.com', SHA2('mysecretpassword', 256), TRUE, NULL),
    ('Bob', 'Williams', 'bob.williams@example.com', SHA2('password456', 256), FALSE, 'token456');

-- Inserting into genres table
INSERT INTO genres (name, description) 
VALUES
    ('Action', 'High-energy scenes, stunts, and activities.'),
    ('Comedy', 'Humorous and lighthearted media.'),
    ('Drama', 'Serious, narrative-driven content.'),
    ('Horror', 'Designed to scare and thrill the audience.');

-- Inserting into media table
INSERT INTO media (title, description, release_date, genre_id, comments_count, views_count, thumbnail, file_name) 
VALUES
    ('Action Movie', 'An exciting action movie.', '2023-01-01', 1, 5, 100, 'images/action_movie.jpg', 'videos/action_movie.mp4'),
    ('Comedy Show', 'A funny comedy show.', '2022-08-15', 2, 10, 200, 'images/comedy_show.jpg', 'videos/comedy_show.mp4'),
    ('Dramatic Film', 'A serious drama.', '2021-10-10', 3, 8, 150, 'images/dramatic_film.jpg', 'videos/dramatic_film.mp4'),
    ('Horror Flick', 'A scary horror movie.', '2024-05-20', 4, 4, 120, 'images/horror_flick.jpg', 'videos/horror_flick.mp4');


-- Inserting into comments table
INSERT INTO comments (media_id, user_id, comment, parent_id) 
VALUES
    (1, 1, 'Loved this movie!', NULL),
    (2, 2, 'This show is hilarious!', NULL),
    (1, 3, 'Not my favorite action movie.', NULL),
    (3, 4, 'The acting was superb.', NULL),
    (4, 1, 'This movie gave me chills.', NULL);

-- Inserting into reviews table
INSERT INTO reviews (media_id, user_id, rating, review) 
VALUES
    (1, 1, 4, 'Great action scenes!'),
    (2, 2, 5, 'One of the funniest shows I have watched.'),
    (3, 3, 3, 'Good storyline but a bit slow.'),
    (4, 4, 5, 'Perfect for horror lovers!'),
    (1, 4, 2, 'Did not live up to my expectations.');

-- Inserting into user_social_links table
INSERT INTO user_social_links (user_id, facebook, instagram, twitter, github) 
VALUES
    (1, 'https://facebook.com/johndoe', 'https://instagram.com/johndoe', NULL, 'https://github.com/johndoe'),
    (2, NULL, 'https://instagram.com/janesmith', 'https://twitter.com/janesmith', NULL),
    (3, 'https://facebook.com/alicejohnson', NULL, 'https://twitter.com/alicejohnson', 'https://github.com/alicejohnson'),
    (4, NULL, NULL, NULL, 'https://github.com/bobwilliams');

-- Inserting into favorites table
INSERT INTO favorites (user_id, media_id) 
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (1, 3);


