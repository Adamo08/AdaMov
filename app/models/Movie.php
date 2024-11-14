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

        // deleteMovie: Deletes a movie by ID (admin-only).
        // updateMovie: Updates movie details (admin-only).
        // We're here

        /**
         * 
         * A function that adds a new movie (admin-only).
         * @param string $title Title of the movie
         * @param string $description Description of the movie
         * @param datetime $release_date Release date of the movie
         * @param string $genre Genres of the movie
         * 
         * @return bool
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
    }