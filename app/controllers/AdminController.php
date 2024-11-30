<?php 

    class AdminController extends Controller {

        /**
         * Shows admin dashboard and statistics (e.g., total movies, users, recent reviews).
        */
        public function index(){
            $this->view('admin/dashboard');
        }

        /**
         * Renders the login page
        */
        public function login(){
            $this->view('admin/auth/login');
        }

        /**
         * Renders The foget password view page
        */
        public function forgot_password(){
            $this->view('admin/auth/forgot_password');
        }

        /**
         * Renders movies view
        */
        public function movies(){
            $this->view("admin/movies");
        }

        /**
         * Renders genres view
         */
        public function genres(){
            $this->view("admin/genres");
        }

        /**
         * Renders users view
         */
        public function users(){
            $this->view("admin/users");
        }

        /**
         * Renders admins view
        */
        public function admins(){
            $this->view("admin/admins");
        }

    }