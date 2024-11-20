<?php

    class MoviesController extends Controller
    {
        /**
         * Render the movie details view.
         * 
         * @param int $id The ID of the movie.
         * @return void
         */
        public function show($id): void
        {
            // Validate if the passed ID
            if (!is_numeric($id) || intval($id) <= 0) {
                $this->view(
                    'error',
                    [
                        'title' => 'Invalid ID',
                        'message' => 'Invalid movie ID provided.'
                    ]
                );
                return;
            }
        
            $MovieModel = new Movie();
            $GenresModel = new Genre();
            $movie = $MovieModel->getMovieById((int)$id);
        
            if (!$movie) {
                $this->view(
                    'error',
                    [
                        'title' => 'Movie Not Found',
                        'message' => 'The requested movie could not be found.'
                    ]
                );
                return;
            }

            $related_movies = $MovieModel->getRelatedMovies($id, $movie['genre_id']);
        
            // Render the movie details view.
            $this->view(
                'movie_details',
                [
                    'title' => $movie['title'],
                    'id' => $movie['id'],
                    'movie' => $movie,
                    'category' => $GenresModel->getName($MovieModel->getCategoryID($id)),
                    'related_movies' => $related_movies
                ]
            );
        }


    }
