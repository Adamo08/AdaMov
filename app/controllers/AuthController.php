<?php


    class AuthController extends Controller {
        private $emailService;

        public function __construct() {
            $this->emailService = new EmailService();
        }

        public function index() {
            $data = ["name" => "Login Page"];
            $this->view('login', $data);
        }

        public function signup() {
            $data = ["name" => "Registration Page"];
            $this->view('register', $data);
        }

        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $email = sanitizeInput($_POST['email']);
                $password = sanitizeInput($_POST['password']);
        
                // Validation: Check if fields are empty
                if (empty($email) || empty($password)) {
                    $data = ["failed" => "Both email and password are required."];
                    $this->view('login', $data);
                    return;
                }
        
                // Validation: Check email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data = ["failed" => "Invalid email format."];
                    $this->view('login', $data);
                    return;
                }
        
                // Fetch user data by email
                $user = new User();
                $userData = $user->getUserByEmail($email);
        
                if ($userData) {
                    // Verify password using SHA-256
                    $hashedPassword = hash('sha256', $password);
                    if ($hashedPassword === $userData['password']) {
                        // Check if email is verified
                        if ($userData['status'] === 1) {
                            if (session_status() === PHP_SESSION_NONE){
                                session_start();
                            }
                            $_SESSION['user_id'] = $userData['id'];
                            $_SESSION['user_name'] = $userData['fname'] . ' ' . $userData['lname'];
                            // header("Location: " . SITE_NAME . "/test");
                            // exit();

                            $this->view('test',$userData);

                        } else {

                            $data = ["failed" => "Your email is not verified. Please check your email for the verification link."];
                            $this->view('login', $data);

                        }
                    } else {
                        $data = ["failed" => "Login failed. Invalid email or password!"];
                        $this->view('login', $data);
                    }
                } else {
                    $data = ["failed" => "Login failed. Invalid email or password!"];
                    $this->view('login', $data);
                }
            }
        }
        
        public function register() {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fname = sanitizeInput($_POST['fname']);
                $lname = sanitizeInput($_POST['lname']);
                $email = sanitizeInput($_POST['email']);
                $password = sanitizeInput($_POST['password']);
                $token = generateRandomToken();

                if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
                    $data = ["error" => "All fields are required. Please fill in all fields."];
                    $this->view('register', $data);
                    return;
                }
        
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data = ["error" => "Invalid email format."];
                    $this->view('register', $data);
                    return;
                }
        
                $user = new User();
        
                if ($user->createUser($fname, $lname, $email, $password, $token)) {
                    $verificationLink = SITE_NAME . "auth/verify/$token";
                    $this->emailService->sendVerificationEmail($email, $verificationLink);
                    $data = ["success" => "Registration successful. A verification email has been sent to your email address."];
                    $this->view('register', $data);
                } else {
                    $data = ["error" => "Registration failed. The email might already be taken."];
                    $this->view('register', $data);
                }
            }
        }
        
        

        /**
         * A function that verifies a user by token
         * 
        */
        public function verify($token) {
            $user = new User();
        
            if ($user->verifyUser($token)) {
                $data = [
                    'verify_success' => "Email verified successfully! Please log in to your account."
                ];
                $this->view('login', $data); // Pass data to the view
            } else {
                $data = [
                    'error' => "Invalid or expired verification link."
                ];
                $this->view('error', $data); // Pass error message to the view
            }
        }

        /**
         * Function to logout
        */

        public function logout(){
            session_start();
            session_destroy();
            $this->view('login');
        }

    }
