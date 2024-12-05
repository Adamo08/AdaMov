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
    }