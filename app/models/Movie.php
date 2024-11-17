<?php 


    class Movie extends Model {

        protected $table = "media";

        /**
         * A function that returns the list of available movies/shows (media)
         * @return array
        */
        public function all() {

            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        /**
         * Get trending movies based on views, comments, and release date
         * @param int $limit Number of movies to return (default is 10)
         * @param int $viewThreshold Minimum views count to consider as trending (default is 1000)
         * @return array List of trending movies
        */
        public function getTrendingMovies($limit = 10, $viewThreshold = 1000) {
            
            $query = "
                SELECT *
                FROM 
                    media m
                WHERE 
                    -- m.release_date >= CURDATE() - INTERVAL 1 MONTH   -- Movies released in the last month
                    1 = 1
                    AND 
                    m.views_count >= :viewThreshold               -- Filter based on minimum views
                ORDER BY 
                    m.views_count DESC,                              -- Sort by views count (highest first)
                    m.comments_count DESC,                           -- Then by comments count
                    m.release_date DESC                              -- Then by release date (most recent first)
                LIMIT :limit;                                       -- Limit the result set to the top trending movies
            ";

            // Prepare and execute the query
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':viewThreshold', $viewThreshold, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the results and return them
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * A function that returns the list of movies associated with the specified genre_id.
         * @param int $genre_id
         * @param int|null $limit (if not specified: all movies will be fetched)
         * @return array
        */
        public function getMovies($genre_id, $limit = null) {
            // Base query
            $sql = "SELECT * FROM {$this->table} WHERE genre_id = :genre_id ORDER BY comments_count DESC, views_count DESC";

            // Add LIMIT clause if a limit is specified
            if ($limit !== null) {
                $sql .= " LIMIT " . intval($limit);
            }

            // Prepare and execute the statement
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        /**
         * A function that fetches a movie by its id
         * @param int $id
         * @return mixed
        */

        public function getMovieById($id){
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->query($sql);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        /**
         * 
         * A function that adds a new movie (admin-only).
         * @param string $title Title of the movie
         * @param string $description Description of the movie
         * @param datetime $release_date Release date of the movie
         * @param string $genre Genres of the movie
         * 
         * @return boolean
        */
        public function addMovie($title, $description, $release_date, $genre){
            $genre_obj = new Genre();
            $sql = "INSERT INTO 
                    {$this->table} 
                    (
                        title, 
                        description, 
                        release_date, 
                        genre_id
                    ) 
                    VALUES 
                    (
                        :title, 
                        :description, 
                        :release_date, 
                        :genre_id
                    )
                ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':release_date', $release_date);
            $stmt->bindParam(':genre_id', $genre_obj->getId($genre));

            return $stmt->execute();

        }


        /**
         * A function that deletes a movie by ID (admin-only)
         * @param int $id
         * @return boolean
        */
        public function deleteMovie($id){
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }


        /**
         * Updates movie details (admin-only).
         * 
         * @param int $id - The ID of the movie to update.
         * @param array $data - An associative array containing the fields to update
         * @return bool - Returns true on success, false on failure.
         */
        public function updateMovie($id, $data) {
            $fields = [];
            $params = [];
            foreach ($data as $key => $value) {
                // Only add fields that are valid column names
                if (in_array($key, ['title', 'description', 'release_date', 'genre_id', 'thumbnail', 'file_name'])) {
                    $fields[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            // Add the movie ID to parameters
            $params[':id'] = $id;

            // Join fields to create the SQL query
            $sql = "UPDATE {$this->table} SET " . implode(", ", $fields) . ", updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            
            try {
                $stmt = $this->db->prepare($sql);
                return $stmt->execute($params);
            } catch (PDOException $e) {
                return false;
            }
        }


    }