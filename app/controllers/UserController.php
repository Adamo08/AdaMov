<?php

class UserController extends Controller {

    /**
     * Renders the profile view for the logged-in user
     * @return void
    */
    public function profile() {

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->view(
                'login',
                [
                    'title' => 'Login Page'
                ]
            );
            return;
        }

        $user_id = $_SESSION['user_id'];

        // Initialize models
        $userModel = new User();
        $favoritesModel = new Favorite();
        $movieModel = new Movie(); 
        
        // Fetch user and social links
        $user = $userModel->getUserByID($user_id);
        $social_links = $userModel->getUserSocialLinks($user_id);

        // Fetch recent favorite media IDs
        $recent_favorites = $favoritesModel->getRecentFavorites($user_id);

        // Fetch movie details for each favorite
        $detailed_favorites = [];
        if (!empty($recent_favorites)) {
            foreach ($recent_favorites as $favorite) {
                $movie = $movieModel->getMovieById($favorite['media_id']);
                if ($movie) {
                    $detailed_favorites[] = $movie;
                }
            }
        }

        // Filter displayable social links
        $displayableLinks = [];
        $socialKeys = ['facebook', 'instagram', 'twitter', 'github'];

        foreach ($socialKeys as $key) {
            if (!empty($social_links[$key])) {
                $displayableLinks[$key] = $social_links[$key];
            }
        }

        // Render the profile view
        $this->view(
            'profile',
            [
                'title' => 'Profile',
                'user' => $user,
                'social_links' => $displayableLinks,
                'recent_favorites' => $detailed_favorites // Pass detailed favorites here
            ]
        );
    }

}
