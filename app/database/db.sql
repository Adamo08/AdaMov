CREATE DATABASE IF NOT EXISTS movies_db;
USE movies_db;

--
-- Users table
--
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status BOOLEAN DEFAULT FALSE, -- Email verification status
    verification_token VARCHAR(255) DEFAULT NULL, -- Token for email verification
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--
-- Genres table
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
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL -- To avoid deleting media when a genre is removed
);

--
-- Comments table
--
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    media_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    parent_id INT DEFAULT NULL, -- For threaded replies
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE -- Deletes replies if the original comment is deleted
);

-- 
-- Reviews table
--
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    media_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5), -- Rating from 1 to 5
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 
-- User's Social Links table
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
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Delete social links if the user is deleted
);

--
-- Favorites Table
--
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    media_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);




-- Inserting sample data for the movies_db database with SHA-256 hashed passwords

-- Inserting into users table with hashed passwords
INSERT INTO users (fname, lname, email, password) 
VALUES
    ('John', 'Doe', 'john.doe@example.com', SHA2('password123', 256)),
    ('Jane', 'Smith', 'jane.smith@example.com', SHA2('securepassword', 256)),
    ('Alice', 'Johnson', 'alice.johnson@example.com', SHA2('mysecretpassword', 256)),
    ('Bob', 'Williams', 'bob.williams@example.com', SHA2('password456', 256));

-- Inserting into genres table
INSERT INTO genres (name, description) 
VALUES
    ('Action', 'High-energy scenes, stunts, and activities.'),
    ('Comedy', 'Humorous and lighthearted media.'),
    ('Drama', 'Serious, narrative-driven content.'),
    ('Horror', 'Designed to scare and thrill the audience.'),
    ('Sci-Fi', 'Speculative content featuring futuristic settings and advanced technology.'),
    ('Fantasy', 'Media with magical elements and mythical creatures.'),
    ('Sports', 'Competitive sports events and related themes.'),
    ('Thriller', 'Intense and suspenseful media.'),
    ('Adventure', 'Exciting journeys and explorations.'),
    ('Romance', 'Love stories and emotional connections.');

-- Inserting into media table
INSERT INTO media (title, description, release_date, genre_id, thumbnail, file_name) 
VALUES
    ('A Man With Black Hat', 'A mysterious action-packed story of a man with a black hat.', '2023-03-14', 1, 'thumbnails/a_man_with_black_hat.jpg', 'videos/a_man_with_black_hat.mp4'),
    ('Agent', 'A thrilling spy adventure with unexpected twists.', '2022-06-25', 8, 'thumbnails/agent.jpg', 'videos/agent.mp4'),
    ('Ang Unang Aswang', 'A Filipino horror movie about the first aswang.', '2023-09-09', 4,'thumbnails/ang_unang_aswang.jpg', 'videos/ang_unang_aswang.mp4'),
    ('Another Planet', 'A Sci-Fi journey to a distant planet.', '2021-12-12', 5,'thumbnails/another_planet.jpg', 'videos/another_planet.mp4'),
    ('Baseball Tournament', 'A dramatic sports story about a baseball tournament.', '2020-05-19', 7,'thumbnails/baseball_tournament.jpg', 'videos/baseball_tournament.mp4'),
    ('Basketball Tournament', 'A thrilling sports documentary on a basketball tournament.', '2019-07-30', 7,'thumbnails/basketball_tournament.jpg', 'videos/basketball_tournament.mp4'),
    ('Beyond Horizons', 'An adventure beyond the known world.', '2022-04-22', 9,'thumbnails/beyond_horizons.jpg', 'videos/beyond_horizons.mp4'),
    ('Bloodfist', 'An intense action movie with martial arts.', '2024-01-01', 1,'thumbnails/bloodfist.jpg', 'videos/bloodfist.mp4'),
    ('Coming Soon', 'A preview of the latest blockbuster movies.', '2024-10-10', 1,'thumbnails/coming_soon.jpg', 'videos/coming_soon.mp4'),
    ('Cosmos', 'A Sci-Fi exploration of the universe.', '2021-11-11', 5,'thumbnails/cosmos.jpg', 'videos/cosmos.mp4'),
    ('Dark', 'A suspenseful horror-thriller with twists and turns.', '2022-02-14', 4,'thumbnails/dark.jpg', 'videos/dark.mp4'),
    ('Driving Into Darkness', 'A thriller about a journey into the unknown.', '2023-08-08', 8,'thumbnails/driving_into_darkness.jpg', 'videos/driving_into_darkness.mp4'),
    ('Fauget', 'A dramatic romance story.', '2019-02-18', 10,'thumbnails/fauget.jpg', 'videos/fauget.mp4'),
    ('Halloween', 'A classic horror tale of Halloween terror.', '2024-10-31', 4,'thumbnails/halloween.jpg', 'videos/halloween.mp4'),
    ('Hood', 'An action-packed story from the streets.', '2022-07-07', 1,'thumbnails/hood.jpg', 'videos/hood.mp4'),
    ('Katana', 'A thrilling samurai action movie.', '2023-03-20', 1,'thumbnails/katana.jpg', 'videos/katana.mp4'),
    ('Lights Out', 'A chilling horror movie about fears in the dark.', '2021-10-25', 4,'thumbnails/lights_out.jpg', 'videos/lights_out.mp4'),
    ('Lionhearted Warrior', 'An inspiring drama about a courageous warrior.', '2020-01-01', 3,'thumbnails/lionhearted_warrior.jpg', 'videos/lionhearted_warrior.mp4'),
    ('Love Crosses', 'A romantic tale of love across boundaries.', '2021-02-14', 10,'thumbnails/love_crosses.jpg', 'videos/love_crosses.mp4'),
    ('Multo', 'A Filipino horror movie about a haunting.', '2023-10-13', 4,'thumbnails/multo.jpg', 'videos/multo.mp4'),
    ('Mystic of Castle', 'A fantasy tale set in a mystical castle.', '2022-06-15', 6,'thumbnails/mystic_of_castle.jpg', 'videos/mystic_of_castle.mp4'),
    ('Night Party', 'A comedy about a wild night out.', '2021-12-31', 2,'thumbnails/night_party.jpg', 'videos/night_party.mp4'),
    ('Sail of Fate', 'An adventurous journey on the high seas.', '2020-05-25', 9,'thumbnails/sail_of_fate.jpg', 'videos/sail_of_fate.mp4'),
    ('Scary House', 'A horror story set in an old, haunted house.', '2021-08-15', 4,'thumbnails/scary_house.jpg', 'videos/scary_house.mp4'),
    ('Shadow Door', 'A suspenseful thriller with paranormal elements.', '2022-03-03', 8,'thumbnails/shadow_door.jpg', 'videos/shadow_door.mp4'),
    ('The Great Mansion', 'A drama surrounding the secrets of a grand mansion.', '2021-09-09', 3,'thumbnails/the_great_mansion.jpg', 'videos/the_great_mansion.mp4'),
    ('The Jungle Watcher', 'An action-adventure in the heart of the jungle.', '2023-11-17', 9,'thumbnails/the_jungle_watcher.jpg', 'videos/the_jungle_watcher.mp4');


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


