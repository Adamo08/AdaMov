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

        /**
         * Updates user profile
         * @return void
         */
        public function updateProfile() {
            // Ensure the request is an AJAX POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid request method or empty data.'
                ]);
                return;
            }

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'You must be logged in to update your profile.'
                ]);
                return;
            }

            $user_id = $_SESSION['user_id'];

            // Get input data
            $firstName = sanitizeInput($_POST['firstName']) ?? '';
            $lastName = sanitizeInput($_POST['lastName']) ?? '';
            $email = sanitizeInput($_POST['email']) ?? '';
            $address = sanitizeInput($_POST['address']) ?? '';
            $socialLinks = $_POST['social'] ?? [];

            // Validate basic fields (only check required fields)
            if (empty($firstName) || empty($lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($address)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill out all fields with valid information.'
                ]);
                return;
            }

            // Validate social media URLs (only if provided)
            foreach ($socialLinks as $key => $link) {
                if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
                    echo json_encode([
                        'success' => false,
                        'message' => ucfirst($key) . ' URL is invalid.'
                    ]);
                    return;
                }
            }

            // Initialize the User model
            $userModel = new User();

            // Update user profile
            $updateSuccess = $userModel->updateUserProfile($user_id, [
                'fname' => $firstName,
                'lname' => $lastName,
                'email' => $email,
                'address' => $address
            ]);

            // Update social links
            $socialUpdateSuccess = $userModel->updateUserSocialLinks($user_id, $socialLinks);

            if ($updateSuccess && $socialUpdateSuccess) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Profile updated successfully.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update profile. Please try again later.'
                ]);
            }
        }


        /**
         * Handles avatar file upload
         * @return void
        */
        public function uploadAvatar() {
            // Ensure the request is an AJAX POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['avatar'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No file uploaded or invalid request.'
                ]);
                return;
            }

            // Validate file input (image and size)
            $avatar = $_FILES['avatar'];
            if ($avatar['error'] !== UPLOAD_ERR_OK) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error uploading file.'
                ]);
                return;
            }

            // File type validation
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($avatar['type'], $allowedTypes)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Only image files are allowed.'
                ]);
                return;
            }

            // File size validation (e.g., max 5MB)
            if ($avatar['size'] > 5 * 1024 * 1024) {
                echo json_encode([
                    'success' => false,
                    'message' => 'File size exceeds the maximum limit of 5MB.'
                ]);
                return;
            }

            // Get the file extension
            $fileExtension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
            // Define the new file name using uniqid() to prevent name collisions
            $newAvatarName = 'avatars/' . uniqid('avatar_', false) . '.' . $fileExtension;

            // Get the current avatar from the database
            $user_id = $_SESSION['user_id'];
            $userModel = new User();
            $currentAvatar = $userModel->getAvatar($user_id);

            // If there is a current avatar, delete it
            if ($currentAvatar) {
                $currentAvatarPath = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $currentAvatar;
                if (file_exists($currentAvatarPath)) {
                    unlink($currentAvatarPath);
                }
            }

            // Define the target path for the new avatar
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $newAvatarName;

            // Move the uploaded file
            if (!move_uploaded_file($avatar['tmp_name'], $targetPath)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to move uploaded file.'
                ]);
                return;
            }

            // Update the user's avatar in the database
            $updateSuccess = $userModel->updateAvatar($user_id, $newAvatarName);

            if ($updateSuccess) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Avatar updated successfully.',
                    'new_avatar' =>  $newAvatarName
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update avatar in the database.'
                ]);
            }
        }


        /**
         * Renders user favorites view
         * @return void
        */
        public function favorites() {
            
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
            $favoritesModel = new Favorite();
            $movieModel = new Movie();
            $genreModel = new Genre();
            // Fetching user favorite movie IDs
            $favoriteIds = $favoritesModel->getFavoritesByUser($user_id);
            
            if (empty($favoriteIds)) {
                // If no favorites, render an empty state
                $this->view('favorites', [
                    'title' => 'Your Favorites',
                    'favorites' => []
                ]);
                return;
            }

            // Fetching movie details by IDs
            $movies = [];
            foreach ($favoriteIds as $favorite) {
                $movie = $movieModel->getMovieById($favorite['media_id']);
                if ($movie) {
                    $movie['favorite_at'] = $favorite['created_at'];
                    $movie['genre'] = $genreModel->getName($movieModel->getCategoryID($favorite['media_id']));
                    $movies[] = $movie;
                }
            }

            $this->view(
                'favorites',
                [
                    'title' => 'Your Favorites',
                    'favorites' => $movies
                ]
            );
        }




    }
