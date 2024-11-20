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

        /**
         * Fetches all reviews for a particular movie.
         * @param int $id movie ID
         * @return array
        */
        public function getAllReviewsByMovie($id){
            // Base query
            $sql = "
                    SELECT * FROM {$this->table} 
                    WHERE media_id = :id
                    ORDER BY created_at DESC
                ";

            // Prepare & Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        
        /**
         * Returns the difference between the current date and the date of the review in seconds.
         * @param int $id Review ID.
         * @return int Difference in seconds.
        */
        public function getReviewPassesSeconds($id) {
            // Base query
            $sql = "
                SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(created_at) AS diff_in_seconds
                FROM {$this->table}
                WHERE id = :id
            ";

            // Prepare and execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // Return the difference in seconds
            return $stmt->fetchColumn();
        }



    }