<?php 


    class Review extends Model {
        protected $table = 'reviews';

        /**
         * Renders the total (average) rating of the movie associated with the specified id
         * 
         * @param int $id The ID of the movie.
         * @return float|string The average rating of the movie or a default value if no rating exists.
        */
        public function getTotalRating(int $id) {
            try {
                $sql = "SELECT AVG(rating) AS average_rating FROM {$this->table} WHERE media_id = :id";
                
                // Prepare the SQL statement
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                // Execute the query
                $stmt->execute();

                // Fetch the result, returning null if no ratings exist
                $rating = $stmt->fetchColumn();

                // If no rating found, return a default message or null
                return $rating !== false ? round($rating, 1) : 0;
            } catch (PDOException $e) {
                return "Error: " . $e->getMessage();
            }
        }


    }