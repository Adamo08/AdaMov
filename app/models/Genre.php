<?php 




    class Genre extends Model {
        protected $table = 'genres';

        /**
         * A function that returns the list of available genres
         * @return array
        */
        public function all() {

            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
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
    }