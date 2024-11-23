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

        /**
         * Adds a new review to a movie.
         * @param int $userId The reviewer's ID
         * @param int $movieId The movie's ID
         * @param string $commnet The review or comment for the movie
         * @param int $rating The rating for the movie
         * @return bool True on success (review added), false on failure.
        */
        public function addReview($userId, $movieId, $comment, $rating) {
            // Base query
            $sql = "
                INSERT INTO {$this->table} (user_id, media_id, rating, review)
                VALUES (:user_id, :movie_id, :rating, :review)
            ";

            // Prepare, Bind, and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':review', $comment, PDO::PARAM_STR);
            
            try {
                return $stmt->execute();
            } catch (PDOException $e) {
                error_log('Database Error: ' . $e->getMessage());
                return false;
            }            
        }


        /**
         * Removes a review from the database
         * @param int $id Review ID
         * @return bool True on success, false on failure
        */
        public function deleteReview($id) {
            // Base Query
            $sql = "DELETE FROM {$this->table} WHERE id = :id";

            // Prepare the statement
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }


        /**
         * Checks if a user has already reviewed a specific media.
         *
         * @param int $userId The ID of the user.
         * @param int $mediaId The ID of the media.
         * @return bool Returns true if the user has already reviewed the media, false otherwise.
         */
        public function inReviews($userId, $mediaId) {
            // Base Query
            $query = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND media_id = :media_id";
            $stmt = $this->db->prepare($query);
            
            // Bind the parameters to the query
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':media_id', $mediaId, PDO::PARAM_INT);
            
            // Execute the query
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            
            return $result > 0;
        }

}