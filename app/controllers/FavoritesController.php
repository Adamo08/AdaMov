<?php

    class FavoritesController extends Controller {

        /**
         * Adds a movie to the user's favorites.
         * 
         * @return void
         */
        public function addToFavorites() {
            // Check if user_id and movie_id are passed via POST
            if (isset($_POST['user_id']) && isset($_POST['movie_id'])) {
                $user_id = $_POST['user_id'];
                $movie_id = $_POST['movie_id'];
                
                $favoriteModel = new Favorite();
                
                // Check if the movie is already in favorites
                if ($favoriteModel->isFavorite($user_id, $movie_id)) {
                    // Movie is already in favorites
                    echo json_encode([
                        'success' => false,
                        'message' => 'Movie is already in favorites.'
                    ]);
                } else {
                    // Add the movie to favorites
                    if ($favoriteModel->addFavorite($user_id, $movie_id)) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'Movie added to favorites.'
                        ]);
                    } else {
                        // Failed to add movie to favorites
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to add movie to favorites.'
                        ]);
                    }
                }
            } else {
                // Missing parameters
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing user_id or movie_id.'
                ]);
            }
        }

        /**
         * Removes a movie from the user's favorites.
         * 
         * @return void
         */
        public function removeFromFavorites() {
            // Check if user_id and movie_id are passed via POST
            if (isset($_POST['user_id']) && isset($_POST['movie_id'])) {
                $user_id = $_POST['user_id'];
                $movie_id = $_POST['movie_id'];
                
                $favoriteModel = new Favorite();
                
                // Remove the movie from favorites
                if ($favoriteModel->removeFavorite($user_id, $movie_id)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Movie removed from favorites.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to remove movie from favorites.'
                    ]);
                }
            } else {
                // Missing parameters
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing user_id or movie_id.'
                ]);
            }
        }

        /**
         * Fetches the list of favorite movies for a user.
         * @param int $user_id The user ID
         * @return void
        */
        public function userFavorites($user_id) {
            $favoriteModel = new Favorite(); 
            
            // Fetch the user's favorite movies
            $favorites = $favoriteModel->getFavoritesByUser($user_id);
            
            // Check if the user has any favorites
            if (empty($favorites)) {
                $message = 'You have no favorite movies yet.';
            } else {
                $message = null;
            }

            // Pass the data to the view
            $this->view('favorites/userFavorites', [
                'favorites' => $favorites,
                'message' => $message
            ]);
        }
}
