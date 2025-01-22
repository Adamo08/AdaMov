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
         * Counts the total number of records in the media table.
         *
         * @return int The total number of records in the media table.
         */
        public function count($genre_id=null){
            // Base Query
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE 1=1";
            if($genre_id != null && is_int($genre_id)){
                $sql .= " AND genre_id = :genre_id";
            }
            // Prepare and Execute
            $stmt = $this->db->prepare($sql);

            if($genre_id != null && is_int($genre_id)){
                $stmt -> bindParam(":genre_id",$genre_id,PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchColumn();
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
            $stmt = $this->db->prepare($sql);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Returns category_id of the movie
         * @param int $id 
         * @return int
        */
        public function getCategoryID($id){
            $sql = "SELECT genre_id FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        /**
         * Fetches 4 related movies to the movie with the given id.
         * @param int $id
         * @param int $genre_id
         * @return array
        */
        public function getRelatedMovies($id, $genre_id){
            
            // Base Query
            $sql = "
                    SELECT * FROM {$this->table} 
                    WHERE 
                        genre_id = :genre_id
                    AND 
                        id != :id
                    ORDER BY RAND()
                    LIMIT 4
            ";
            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }


        /**
         * Recommends movies for a specific user based on their favorite genres.
         *
         * @param int $user_id The ID of the user.
         * @return array A list of recommended movies.
        */
        public function recommendMoviesForUser($user_id)
        {
            // Instantiate the Favorite model
            $favoriteModel = new Favorite();

            // Step 1: Get the list of favorite movie IDs for the user
            $favoriteMovies = $favoriteModel->getFavoritesByUser($user_id);

            if (empty($favoriteMovies)) {
                // If no favorites found
                return [];
            }

            // Step 2: Extract movie IDs and fetch genres for those movies
            $favoriteMovieIds = array_column($favoriteMovies, 'media_id');
            $favoriteGenres = [];

            // Loop through favorite movie IDs and fetch their genres
            foreach ($favoriteMovieIds as $movieId) {
                $genreId = $this->getMovieGenre($movieId);
                if ($genreId !== null) {
                    $favoriteGenres[] = $genreId;
                }
            }

            // Remove duplicate genre IDs (if any, for safety)
            $favoriteGenres = array_unique($favoriteGenres);
            if (empty($favoriteGenres)) {
                // If no genres are found
                return [];
            }

            // Step 3: Recommend movies in the same genres but exclude already-favorite movies
            $genrePlaceholders = implode(',', array_fill(0, count($favoriteGenres), '?'));
            $excludePlaceholders = implode(',', array_fill(0, count($favoriteMovieIds), '?'));

            $recommendationQuery = "
                SELECT DISTINCT m.* 
                FROM media m
                JOIN genres g ON m.genre_id = g.id
                WHERE g.id IN ($genrePlaceholders)
                AND m.id NOT IN ($excludePlaceholders)
                ORDER BY RAND()
                LIMIT 6
            ";
            $stmt = $this->db->prepare($recommendationQuery);
            $stmt->execute(array_merge($favoriteGenres, $favoriteMovieIds));

            // Step 4: Return the list of recommended movies
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Fetches the genre ID associated with a specific movie.
         *
         * @param int $movieId The ID of the movie.
         * @return int|null The genre ID if found, otherwise null.
         */
        public function getMovieGenre($movieId)
        {
            $query = "SELECT genre_id FROM {$this->table} WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
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
            $genre_id = $genre_obj->getId($genre);
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
            $stmt->bindParam(':genre_id', $genre_id);

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
         * @param array $data - An associative array containing the fields to update.
         * @return bool - Returns true on success, false on failure.
         */
        public function updateMovie($id, $data)
        {
            // Validate that the movie ID is provided
            if (empty($id) || !is_array($data)) {
                return false;
            }

            // Fetch current movie data
            $currentData = $this->getMovieById($id);
            if (!$currentData) {
                return false;
            }

            // Identify changed fields
            $changes = [];
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $currentData) && $currentData[$key] !== $value) {
                    $changes[$key] = $value;
                }
            }

            // If no changes, return early
            if (empty($changes)) {
                return true;
            }

            // Build the SQL query dynamically
            $fields = [];
            $values = [];
            foreach ($changes as $key => $value) {
                $fields[] = "$key = :$key";
                $values[":$key"] = $value;
            }

            $values[':id'] = $id;
            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";

            try {
                // Execute the query
                $stmt = $this->db->prepare($sql);
                return $stmt->execute($values);
            } catch (PDOException $e) {
                error_log('Failed to update movie: ' . $e->getMessage());
                return false;
            }
        }



    /**
     * Returns the thumbnail for the specified movie
     * @param int $id movie's ID
     * @return string 
    */
    public function getThumbnail($id){
        // Base Query
        $sql = "SELECT thumbnail FROM {$this->table} WHERE id = :id";
        // Prepare AND Execute
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Returns the mp4 media file name for the specified movie
     * @param int $id movie's ID
     * @return string 
    */
    public function getMediaMP4($id){
        // Base Query
        $sql = "SELECT file_name FROM {$this->table} WHERE id = :id";
        // Prepare AND Execute
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}