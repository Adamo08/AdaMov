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
         * A function that returns the list of movies associated with the specified genre_id.
         * @param int $genre_id
         * @return array
        */
        public function getMovies($genre_id){
            $sql = "SELECT * FROM {$this->table} WHERE genre_id = :genre_id";
            $stmt = $this->db->prepare($sql);
            $stmt -> bindParam(':genre_id',$genre_id, PDO::PARAM_INT);
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