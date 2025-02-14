<?php 

class AdminController extends Controller {

    /**
     * Shows admin dashboard and statistics (e.g., total movies, users, recent reviews).
     * Checks if the admin is logged in before rendering the dashboard.
     */
    public function index(){
        if (!isset($_SESSION['admin_id'])) {
            // Redirect to login
            header("Location: " . SITE_NAME."admin/login");
            exit();
        }

        // Pass statistics or any required data to the dashboard view
        $movieModel = new Movie();
        $genreModel = new Genre();
        $userModel = new User();
        $adminModel = new Admin();

        $statistics = [
            'total_movies' => $movieModel->count(),
            'total_genres' => $genreModel->count(),
            'total_users' => $userModel->count(),
            'total_admins' => $adminModel->count(),
        ];

        $this->view('admin/dashboard', ['statistics' => $statistics]);
    }

    /**
     * Renders the login view.
     */
    public function login(){
        if (isset($_SESSION['admin_id'])) {
            // Redirect to dashboard if already authenticated
            header("Location: " . SITE_NAME."admin/");
            exit();
        }

        $data = ["title" => "AdaMov | Admin Login"];
        $this->view('admin/auth/login', $data);
    }

    /**
     * Handles login authentication.
     */
    public function signin()
    {
        if (isset($_SESSION['admin_id'])) {
            // Redirect to dashboard if already authenticated
            header("Location: " . url("admin/"));
            exit;
        }

        // Ensure session handling is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize user input
            $email = sanitizeInput($_POST['email'] ?? '');
            $password = sanitizeInput($_POST['password'] ?? '');

            // Validation: Check if fields are empty
            if (empty($email) || empty($password)) {
                $data = [
                    "title" => "Invalid data",
                    "failed" => "Both email and password are required."
                ];
                $this->view('admin/auth/login', $data);
                return;
            }

            // Validation: Check email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data = [
                    "title" => "Invalid data",
                    "failed" => "Invalid email format."
                ];
                $this->view('admin/auth/login', $data);
                return;
            }

            // Fetch admin by email
            $admin = new Admin();
            $adminData = $admin->getAdminByEmail($email);

            if ($adminData) {
                // Verify password
                $hashedPassword = hash('sha256', $password);
                if ($hashedPassword == $adminData['password']) {
                    // Password matches, set session variables
                    $_SESSION['admin_id'] = $adminData['id'];
                    $_SESSION['admin_name'] = $adminData['fname'] . ' ' . $adminData['lname'];
                    $_SESSION['admin_avatar'] = $adminData['avatar'];

                    // // Redirect to dashboard
                    header("Location: " . SITE_NAME."admin/");
                    exit();

                } else {
                    // Incorrect password
                    $data = [
                        "title" => "Login Failed",
                        "failed" => "Login failed. Invalid email or password!"
                    ];
                    $this->view('admin/auth/login', $data);
                }
            } else {
                // Admin not found
                $data = ["failed" => "Login failed. Invalid email or password!"];
                $this->view('admin/auth/login', $data);
            }
        }
    }

    /**
     * Handles admin logout.
     */
    public function logout(){
        session_destroy();
        $this->view(
            'admin/auth/login',
            ['title' => 'Logging Out']
        );
    }

    /**
     * Renders the forgot password page.
     */
    public function forgot_password(){
        $this->view('admin/auth/forgot_password');
    }



    /***************************
     * Movies Related Actions
     ***************************/


    /**
    * ==> Renders the movies view.
    */
    public function movies(){
        $this->authenticate();

        $movieModel = new Movie();
        $genreModel = new Genre();
        $movies = $movieModel->all();
        $genres = $genreModel->all();
        foreach ($movies as &$movie) {
            $movie['genre'] = $genreModel->getName($movie['genre_id']);
        }
        unset($movie);
        $this->view(
            "admin/movies/movies", 
            [
                'title' => 'Movies',
                'movies' => $movies,
                'genres' => $genres
            ]
        );
    }

    /**
     * ==> Renders the view for adding new movies
    */
    public function add_movie(){
        $this->authenticate();
        $genreModel = new Genre();
        $genres = $genreModel->getName();
        $this->view(
            "admin/movies/add_movie", 
            [
                'title' => 'Add Movie',
                'genres' => $genres
            ]
        );

    }


    /**
     * ==> Removing Movie Action
    */
    public function remove_movie()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate user ID
            $movieId = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : null;

            if ($movieId) {
                $movieModel = new Movie();
                
                // Fetch the avatar path
                $thumbnail = $movieModel->getThumbnail($movieId);
                $media_mp4 = $movieModel->getMediaMP4($movieId);

                // Attempt to delete the user from the database
                if ($movieModel->deleteMovie($movieId)) {
                    // Check if avatar exists and delete it
                    if ($thumbnail && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $thumbnail)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $thumbnail);
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $media_mp4);
                    }

                    // Respond with success
                    echo json_encode([
                        'success' => true,
                        'message' => 'Movie has been successfully removed.'
                    ]);
                } else {
                    // Deletion failed
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to remove movie. Please try again later.'
                    ]);
                }
            } else {
                // Invalid or missing user ID
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid movie ID provided.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }

    /**
     * ==> Updating movies action
     */
    public function update_movie()
    {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input data
            $id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : null;
            $data = $_POST;
            unset($data['movie_id']);

            // Ensure the movie ID is provided
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'Movie ID is required.']);
                return;
            }

            // Instantiate the Movie model
            $movie = new Movie();

            // Call the updateMovie method
            $result = $movie->updateMovie($id, $data);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Movie updated successfully.']);
            } else {
                error_log("Failed to update movie with ID: $id. Data provided: " . json_encode($data));
                echo json_encode(['status' => 'error', 'message' => 'Failed to update movie. Please try again.']);
            }
        } else {
            // Handle invalid request methods
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }


    /**
     * ==> Adding movies action 
     */
    public function addMovie()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Validate required fields
            $title = isset($_POST['title']) ? trim($_POST['title']) : null;
            $description = isset($_POST['description']) ? trim($_POST['description']) : null;
            $releaseDate = isset($_POST['release_date']) ? trim($_POST['release_date']) : null;
            $genre = isset($_POST['genre']) ? trim($_POST['genre']) : null;
            $duration = isset($_POST['duration']) ? trim($_POST['duration']) : null;
            $quality = isset($_POST['quality']) ? trim($_POST['quality']) : null;

            // Validate file inputs
            $thumbnail = isset($_FILES['thumbnail']) ? $_FILES['thumbnail'] : null;
            $mediaFile = isset($_FILES['file_name']) ? $_FILES['file_name'] : null;

            // Check if all required fields are provided
            if (!$title || !$description || !$releaseDate || !$genre || !$duration || !$quality || !$thumbnail || !$mediaFile) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all the fields and upload necessary files.'
                ]);
                return;
            }

            // Validate duration
            if (!is_numeric($duration) || $duration <= 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid movie duration provided.'
                ]);
                return;
            }

            // Handle file uploads (Thumbnail and Movie File)
            $thumbnailPath = null;
            $mediaPath = null;
            
            // Upload Thumbnail
            $thumbnailDir = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/';
            if ($thumbnail && $thumbnail['error'] === UPLOAD_ERR_OK) {
                $thumbnailExt = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
                $thumbnailPath = 'thumbnails/'.uniqid('thumb_') . '.' . $thumbnailExt;
                $thumbnailTargetPath = $thumbnailDir . $thumbnailPath;

                if (!move_uploaded_file($thumbnail['tmp_name'], $thumbnailTargetPath)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to upload thumbnail. Please try again.'
                    ]);
                    return;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error uploading thumbnail.'
                ]);
                return;
            }

            // Upload Movie File (MP4 or any media type)
            $mediaDir = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/';
            if ($mediaFile && $mediaFile['error'] === UPLOAD_ERR_OK) {
                $mediaExt = pathinfo($mediaFile['name'], PATHINFO_EXTENSION);
                $mediaPath = 'videos/'.uniqid('movie_') . '.' . $mediaExt;
                $mediaTargetPath = $mediaDir . $mediaPath;

                if (!move_uploaded_file($mediaFile['tmp_name'], $mediaTargetPath)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to upload movie file. Please try again.'
                    ]);
                    return;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error uploading movie file.'
                ]);
                return;
            }

            // Prepare the movie data for database insertion
            $movieData = [
                'title' => $title,
                'description' => $description,
                'release_date' => $releaseDate,
                'genre' => $genre,
                'duration' => $duration,
                'quality' => $quality,
                'thumbnail' => $thumbnailPath,
                'media_file' => $mediaPath,
            ];

            // Insert movie into the database
            $movieModel = new Movie();
            $inserted = $movieModel->addMovie($movieData);

            if ($inserted) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Movie added successfully!'
                ]);
            } else {
                // In case insertion fails
                // Delete uploaded files if insertion failed
                unlink($thumbnailTargetPath);
                unlink($mediaTargetPath);

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to add movie. Please try again later.'
                ]);
            }

        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }




    /**************************
     * Genres Related Actions
     **************************/


    /**
     * ==> Renders the genres view.
     */
    public function genres(){
        $this->authenticate();
        $genreModel = new Genre();
        $movieModel = new Movie();
        $genres = $genreModel->all();
        foreach($genres as &$genre){
            $genre['total_movies'] = $movieModel->count($genre['id']);
        }
        $this->view(
            "admin/genres/genres", 
            [
                'title' => 'Genres',
                'genres' => $genres
            ]
        );
    }

    /**
     * ==> Renderes the view for adding new genres
    */
    public function add_genre(){
        $this->authenticate();
        $this->view(
            "admin/genres/add_genre", 
            ['title' => 'Add Genre']
        );
    }

    /**
     * ==> Genre addition Action
     */
    public function addGenre() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize user input
            $genreName = isset($_POST['genre_name']) ? trim($_POST['genre_name']) : '';
            $genreDescription = isset($_POST['genre_description']) ? trim($_POST['genre_description']) : '';
    
            // Validation: Check if genre name|description is empty
            if (!$genreName || !$genreDescription) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all fields.'
                ]);
                return;
            }
    
            // Insert genre into the database
            $genreModel = new Genre();
            // Check if genre already exists
            if ($genreModel->genreExists($genreName)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Genre already exists.'
                ]);
                return;
            }

            $result = $genreModel->addGenre($genreName, $genreDescription);
    
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Genre added successfully.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to add genre. Please try again later.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }

    /**
     * ==> Removing Genre Action (clearing name and description)
     */
    public function remove_genre()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate genre ID
            $genreId = isset($_POST['genreId']) ? intval($_POST['genreId']) : null;

            if ($genreId) {
                $genreModel = new Genre();
                
                // Attempt to clear the name and description of the genre
                if ($genreModel->removeGenre($genreId)) {
                    // Respond with success
                    echo json_encode([
                        'success' => true,
                        'message' => 'Genre removed successfully.'
                    ]);
                } else {
                    // Operation failed
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to remove genre details. Please try again later.'
                    ]);
                }
            } else {
                // Invalid or missing genre ID
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid genre ID provided.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }


    /**
     * ==> Updating genres action
     */
    public function update_genre()
    {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input data
            $id = isset($_POST['genreId']) ? intval($_POST['genreId']) : null;
            $data = $_POST;
            unset($data['genreId']);

            // Ensure the movie ID is provided
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'Genre ID is required.']);
                return;
            }

            // Instantiate the Movie model
            $genre = new Genre();

            // Call the updateMovie method
            $result = $genre->updateGenre($id, $data);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Genre updated successfully.']);
            } else {
                error_log("Failed to update genre with ID: $id. Data provided: " . json_encode($data));
                echo json_encode(['status' => 'error', 'message' => 'Failed to update genre. Please try again.']);
            }
        } else {
            // Handle invalid request methods
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }


    /************************
     * Users Related Actions
     ************************/


    /**
     * ==> Renders the users view.
     */
    public function users(){
        $this->authenticate();
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $this->view(
            "admin/users/users", 
            [
                'title' => 'Users',
                'users' => $users
            ]
        );
    }

    /**
     * ==> Renders the view for adding new users
    */
    public function add_user(){
        $this->authenticate();
        $this->view(
            "admin/users/add_user", 
            ['title' => 'Add User']
        );
    }

    /**
     * ==> Adding Users Action
     */
    public function addUser()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input data
            $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
            $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
            $address = isset($_POST['address']) ? trim($_POST['address']) : null;
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $password = isset($_POST['password']) ? trim($_POST['password']) : null;

            // Ensure required fields are provided
            if ($firstName && $lastName && $address && $email && $password) {
                $userModel = new User();

                // Generate a unique verification token (set to null since admin-added users are verified)
                $token = null;

                // Process the avatar file
                $avatar = null;
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['avatar']['tmp_name'];
                    $fileName = $_FILES['avatar']['name'];
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $avatar = 'avatars/' . uniqid() . '.' . $fileExtension;

                    // Move the uploaded file to the desired directory
                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $avatar;
                    if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to upload avatar.',
                        ]);
                        return;
                    }
                }

                // Attempt to create the user with verified status
                $isUserCreated = $userModel->createUser(
                    $firstName,
                    $lastName,
                    $email,
                    $password,
                    $token,
                    $avatar,
                    $address,
                    true
                );

                if ($isUserCreated) {
                    // Respond with success
                    echo json_encode([
                        'success' => true,
                        'message' => 'User has been successfully added.',
                    ]);
                } else {
                    // Failed to create user
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to add user. Email may already exist.',
                    ]);
                }
            } else {
                // Invalid or missing data
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid or missing input data.',
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.',
            ]);
        }
    }



    /**
     * ==> Removing Users Action
    */
    public function remove_user()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate user ID
            $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

            if ($userId) {
                $userModel = new User();
                
                // Fetch the avatar path
                $avatarPath = $userModel->getAvatar($userId);

                // Attempt to delete the user from the database
                if ($userModel->deleteUser($userId)) {
                    // Check if avatar exists and delete it
                    if ($avatarPath && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $avatarPath)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/' . $avatarPath);
                    }

                    // Respond with success
                    echo json_encode([
                        'success' => true,
                        'message' => 'User has been successfully removed.'
                    ]);
                } else {
                    // Deletion failed
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to remove user. Please try again later.'
                    ]);
                }
            } else {
                // Invalid or missing user ID
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid user ID provided.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }

    /**
     * ==> Updating users action
    */
    public function update_user() {

        // Ensure the request is an AJAX POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method or empty data.'
            ]);
            return;
        }

        // Check if the admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'You must be logged in process this action.'
            ]);
            return;
        }

        $user_id = $_POST['user_id'];

        // Get input data
        $firstName = sanitizeInput($_POST['fname']) ?? '';
        $lastName = sanitizeInput($_POST['lname']) ?? '';
        $email = sanitizeInput($_POST['email']) ?? '';
        $address = sanitizeInput($_POST['address']) ?? '';

        // Validate basic fields (only check required fields)
        if (empty($firstName) || empty($lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($address)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fill out all fields with valid information.'
            ]);
            return;
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


        if ($updateSuccess) {
            echo json_encode([
                'success' => true,
                'message' => 'User updated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update user. Please try again later.'
            ]);
        }
    }




    /***************************
     * Admins Related Actions
     ***************************/

    /**
     * ==> Renders the admins view.
     */
    public function admins(){
        $this->authenticate();
        $adminModel = new Admin();
        $admins = $adminModel->all();
        $this->view(
            "admin/admins/admins", 
            [
                "title" => 'Admins',
                'admins' => $admins
            ]
        );
    }

    /**
     * ==> Renders the view for adding new admins
    */
    public function add_admin(){
        $this->authenticate();
        $this->view(
            "admin/admins/add_admin",
            ['title' => 'Add Admin']
        );
    }

    /**
     * ==> Updating Admins Action
     */
    public function updateAdmin() {
        // Ensure the request is an AJAX POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method or empty data.'
            ]);
            return;
        }

        // Check if the admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'You must be logged in to process this action.'
            ]);
            return;
        }

        $admin_id = $_POST['admin_id'];

        // Get input data
        $firstName = sanitizeInput($_POST['fname']) ?? '';
        $lastName = sanitizeInput($_POST['lname']) ?? '';
        $email = sanitizeInput($_POST['email']) ?? '';
        $password = $_POST['password'] ?? '';

        // Validate basic fields
        if (empty($firstName) || empty($lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fill out all required fields with valid information.'
            ]);
            return;
        }

        // Initialize the Admin model
        $adminModel = new Admin();

        // Prepare the update data
        $updateData = [
            'fname' => $firstName,
            'lname' => $lastName,
            'email' => $email
        ];

        // If a new password is provided, hash it and update it
        if (!empty($password)) {
            $updateData['password'] = hash('sha256', $password);
        }

        // Update admin profile
        $updateSuccess = $adminModel->updateAdminProfile($admin_id, $updateData);

        if ($updateSuccess) {
            echo json_encode([
                'success' => true,
                'message' => 'Admin updated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update admin. Please try again later.'
            ]);
        }
    }

    /**
     * ==> Removing Admins Action
     */
    public function removeAdmin(){
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate admin ID
            $adminId = isset($_POST['admin_id']) ? intval($_POST['admin_id']) : null;

            if ($adminId) {
                $adminModel = new Admin();
                
                // Fetch the admin's avatar path
                $avatarPath = $adminModel->getAvatar($adminId);

                // Attempt to remove the admin from the database
                if ($adminModel->removeAdmin($adminId)) {
                    // Check if the avatar exists and delete it
                    if ($avatarPath && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/admin/' . $avatarPath)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/admin/' . $avatarPath);
                    }

                    // Respond with success
                    echo json_encode([
                        'success' => true,
                        'message' => 'Admin removed successfully.'
                    ]);
                } else {
                    // Operation failed
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to remove Admin. Please try again later.'
                    ]);
                }
            } else {
                // Invalid or missing admin ID
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid admin ID provided.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }

    /**
     * ==> Adding Admin Action
     */
    public function addAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $addedBy = $_POST['added_by'];
            
            // Validate required fields
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'All fields are required.']);
                return;
            }

            // Hash the password
            $hashedPassword = hash("sha256", $password);

            // Process the avatar file
            $avatar = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileName = $_FILES['avatar']['name'];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $avatar = 'avatars/' . uniqid() . '.' . $fileExtension;

                // Move uploaded file
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/AdaMov/public/assets/admin/' . $avatar;
                if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload avatar.']);
                    return;
                }
            }

            // Prepare data
            $data = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $hashedPassword,
                'avatar' => $avatar,
                'added_by' => $addedBy
            ];

            $adminModel = new Admin();

            if ($adminModel->addAdmin($data)) {
                echo json_encode(['success' => true, 'message' => 'Admin added successfully.']);
            } else {
                 // If admin wasn't added, delete the uploaded avatar
                if ($avatar && file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                echo json_encode(['success' => false, 'message' => 'Failed to add admin.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }



    /**
     * ==> Renders the contact view for admins
    */
    public function contact_admin(){
        $this->authenticate();
        $adminModel = new Admin();
        $admins = $adminModel->all();
        $this->view(
            "admin/admins/contact_admin",
            [
                'title' => 'Contact Admin',
                'admins' => $admins
            ]
        );
    }

    /**
     * ==> Sending a message action
     */
    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sender_id = isset($_POST['sender_id']) ? trim($_POST['sender_id']) : null;
            $receiver_id = isset($_POST['receiver_id']) ? trim($_POST['receiver_id']) : null;
            $message = isset($_POST['message']) ? trim($_POST['message']) : null;

            // Validate input fields
            if (!$sender_id || !$receiver_id || !$message) {
                echo json_encode([
                    'success' => false,
                    'message' => 'All fields are required.'
                ]);
                return;
            }

            if ($sender_id == $receiver_id) {
                echo json_encode([
                    'success' => false,
                    'message' => 'You cannot send a message to yourself.'
                ]);
                return;
            }

            // Sanitize message input to prevent XSS (strip HTML and special chars)
            $message = sanitizeInput($message);

            // Handle file upload with 5MB size limit
            $attachmentPath = null;
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/AdaMov/public/assets/admin/attachments/";

            if (!empty($_FILES['attachment']['name'])) {
                $fileTmpPath = $_FILES['attachment']['tmp_name'];
                $fileName = uniqid('attach_');
                $fileExtension = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
                // Error log the extension
                error_log($fileExtension);
                $fileSize = $_FILES['attachment']['size']; // Get file size in bytes
                $maxSize = 5 * 1024 * 1024; // 5MB in bytes
                $allowedExtensions = ["jpg", "jpeg", "png", "pdf", "docx"];

                // Validate file type
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid file type. Allowed types: jpg, jpeg, png, pdf, docx.'
                    ]);
                    return;
                }

                // Validate file size
                if ($fileSize > $maxSize) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'File size exceeds 5MB limit.'
                    ]);
                    return;
                }

                // Create directory if not exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Define file path
                $attachmentPath = "attachments/" . $fileName. '.' . $fileExtension;
                $fullFilePath = $uploadDir . $fileName. '.' . $fileExtension;

                // Move uploaded file
                if (!move_uploaded_file($fileTmpPath, $fullFilePath)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to upload attachment.'
                    ]);
                    return;
                }
            }

            // Prepare message data for insertion
            $messageData = [
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'attachment' => $attachmentPath
            ];

            // Insert message into the database
            $adminModel = new Admin();
            $inserted = $adminModel->sendMessage($messageData);

            if ($inserted) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Message sent successfully!'
                ]);
            } else {
                // Delete uploaded file if message failed to send
                if ($attachmentPath) {
                    unlink($fullFilePath);
                }

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to send message. Please try again later.'
                ]);
            }
        } else {
            // Invalid request method
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method. Use POST for this action.'
            ]);
        }
    }


    /**
     * Helper function to check if the admin is authenticated.
     * Redirects to the login page if not authenticated.
     */
    private function authenticate(){
        if (!isset($_SESSION['admin_id'])) {
            header("Location: " . SITE_NAME."admin/login");
            exit();
        }
    }
}
