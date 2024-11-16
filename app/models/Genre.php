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
            $stmt -> bindColumn(':name', $genre, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result['id'];
        }

        /**
         * Returns the genre name associated with the specified id
         * @param int $id
         * @return string
        */
        public function getName($id) {
            $sql = "SELECT name FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }