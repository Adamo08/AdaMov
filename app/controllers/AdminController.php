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

    /**
     * Renders the movies view.
     */
    public function movies(){
        $this->authenticate();

        $movieModel = new Movie();
        $genreModel = new Genre();
        $movies = $movieModel->all();
        foreach ($movies as &$movie) {
            $movie['genre'] = $genreModel->getName($movie['genre_id']);
        }
        unset($movie);
        $this->view("admin/movies", ['movies' => $movies]);
    }

    /**
     * Renders the genres view.
     */
    public function genres(){
        $this->authenticate();
        $genreModel = new Genre();
        $movieModel = new Movie();
        $genres = $genreModel->all();
        foreach($genres as &$genre){
            $genre['total_movies'] = $movieModel->count($genre['id']);
        }
        $this->view("admin/genres", ['genres' => $genres]);
    }

    /**
     * Renders the users view.
     */
    public function users(){
        $this->authenticate();
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $this->view("admin/users", ['users' => $users]);
    }

    /**
     * Renders the admins view.
     */
    public function admins(){
        $this->authenticate();
        $adminModel = new Admin();
        $admins = $adminModel->all();
        $this->view("admin/admins", ['admins' => $admins]);
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
