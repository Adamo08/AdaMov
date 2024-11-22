<?php

    class Favorite extends Model
    {
        protected $table = 'favorites';

        /**
         * Fetches all favorite movies for a user.
         * 
         * @param int $id User's ID.
         * @return array|null List of favorite movies or null if none exist.
        */
        public function getFavoritesByUser(int $id): ?array
        {
            // Base Query
            $sql = "SELECT media_id FROM {$this->table} WHERE user_id = :id";

            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch results
            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $favorites ?: null;
        }

        /**
         * Adds a movie to the user’s favorites.
         * 
         * @param int $id User's ID.
         * @param int $media_id Movie ID.
         * @return bool True on success, false on failure.
        */
        public function addFavorite(int $id, int $media_id): bool
        {
            // Base Query
            $sql = "INSERT INTO {$this->table} (user_id, media_id) VALUES (:user_id, :media_id)";

            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':media_id', $media_id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        /**
         * Removes a movie from the user’s favorites.
         * 
         * @param int $id User's ID.
         * @param int $media_id Movie ID.
         * @return bool True on success, false on failure.
        */
        public function removeFavorite(int $id, int $media_id): bool
        {
            // Base Query
            $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id AND media_id = :media_id";

            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':media_id', $media_id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        /**
         * Checks if a movie is already in the user’s favorites.
         *
         * @param int $user_id User's ID.
         * @param int $media_id Movie ID.
         * @return bool True if the movie is in favorites, false otherwise.
        */
        public function isFavorite(int $user_id, int $media_id): bool
        {
            // Base Query
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND media_id = :media_id";

            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':media_id', $media_id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the count
            $count = $stmt->fetchColumn();

            // Return true if the count is greater than 0
            return $count > 0;
        }

    }
