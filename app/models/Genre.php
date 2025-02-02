<?php 




    class Genre extends Model {
        protected $table = 'genres';

        /**
         * A function that returns the list of available genres
         * @return array
        */
        public  function all() {

            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }

        /**
         * Counts the total number of records in the genres table.
         *
         * @return int The total number of records in the genres table.
         */
        public function count(){
            // Base Query
            $sql = "SELECT COUNT(*) FROM {$this->table}";
            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }


        /**
         * Fetches a limited number of genres from the database.
         *
         * @param int $limit The number of genres to retrieve. Default is 5.
         * @return array An array of genres, each represented as an associative array.
        */
        public function getLimited($limit = 5) {
            $query = "SELECT name FROM {$this->table} LIMIT :limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        /**
         * A function that returns the id of a specific genre
         * @param string $genre
         * @return int
         * 
        */
        public function getId($genre) {
            $sql = "SELECT id FROM {$this->table} WHERE name = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $genre, PDO::PARAM_STR);
            $stmt->execute();
        
            $result = $stmt->fetchColumn();
            return $result;
        }
        

        /**
         * Returns the genre name(s) associated with the specified id or all genres if no id is provided
         * @param int|null $id
         * @return string|array
        */
        public function getName($id = null) {
            if ($id === null) {
                // Fetch all genre names
                $sql = "SELECT id, name FROM {$this->table}";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Fetch a single genre name by ID
                $sql = "SELECT name FROM {$this->table} WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchColumn();
            }
        }


        /**
         * Fetches a row from the database using the specified genre
         * @param string $genre
         * @param array
        */
        public function getGenreByGenre($genre) {
            // Prepare the SQL query
            $sql = "SELECT * FROM {$this->table} WHERE name = :genre";
            
            // Prepare AND execute the query
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->execute();

            // Return the result as an array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        /**
         * Updates genre details (admin-only).
         * 
         * @param int $id - The ID of the genre to update.
         * @param array $data - An associative array containing the fields to update (name and/or description).
         * @return bool - Returns true on success, false on failure.
         */
        public function updateGenre($id, $data)
        {
            // Validate that the genre ID is provided
            if (empty($id) || !is_array($data)) {
                return false;
            }

            // Fetch current genre data
            $currentData = $this->getGenreById($id);
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
                error_log('Failed to update genre: ' . $e->getMessage());
                return false;
            }
        }

        /**
         * Clears the name and description of a genre.
         * 
         * @param int $id - The ID of the genre to clear.
         * @return bool - Returns true on success, false on failure.
         */
        public function removeGenre($id)
        {
            // Validate the genre ID
            if (empty($id) || !is_numeric($id) || $id <= 0) {
                return false;
            }

            // Prepare the SQL query to clear name and description
            $sql = "DELETE FROM {$this->table} WHERE id = :id";

            try {
                // Execute the query
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $result = $stmt->execute();

                // Return the result of the query execution
                return $result;
            } catch (PDOException $e) {
                error_log('Failed to clear genre fields: ' . $e->getMessage());
                return false;
            }
        }


        /**
         * Adds a new genre with the given name and description.
         * 
         * @param string $name - The name of the genre.
         * @param string $description - The description of the genre.
         * @return bool - Returns true on success, false on failure.
         */
        public function addGenre($name, $description)
        {
            // Validate the genre name
            if (empty($name) || empty($description)) {
                return false;
            }

            // Prepare the SQL query to insert a new genre
            $sql = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";

            try {
                // Execute the query
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                $result = $stmt->execute();

                // Return the result of the query execution
                return $result;
            } catch (PDOException $e) {
                error_log('Failed to add genre: ' . $e->getMessage());
                return false;
            }
        }

        /**
         * Checks if a genre with the given name already exists.
         * 
         * @param string $name - The name of the genre to check.
         * @return bool - Returns true if the genre exists, false otherwise.
         */
        public function genreExists($name)
        {
            // Validate the genre name
            if (empty($name)) {
                return false;
            }

            // Prepare the SQL query to check if the genre exists
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE name = :name";

            try {
                // Execute the query
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->execute();

                // Fetch the result
                $count = $stmt->fetchColumn();

                // Return true if the genre exists, false otherwise
                return $count > 0;
            } catch (PDOException $e) {
                error_log('Failed to check if genre exists: ' . $e->getMessage());
                return false;
            }
        }

        /**
         * Fetches genre details by its ID.
         * 
         * @param int $id - The ID of the genre to fetch.
         * @return array|false - Returns an associative array with the genre details or false if not found.
         */
        public function getGenreById($id)
        {
            // Validate that the genre ID is a positive integer
            if (empty($id) || !is_numeric($id) || $id <= 0) {
                return false;
            }

            // Prepare the SQL query to fetch genre data by ID
            $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";

            try {
                // Execute the query
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the result
                $genre = $stmt->fetch(PDO::FETCH_ASSOC);

                // Return the genre data if found, otherwise return false
                return $genre ? $genre : false;
            } catch (PDOException $e) {
                error_log('Failed to fetch genre: ' . $e->getMessage());
                return false;
            }
        }



    }