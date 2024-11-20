<?php 



    class HomeController extends Controller
    {
        /**
         * Renders the home view.
        */
        public function index()
        {
            $data = ["title"=>"Home Page"];
            $this->view('home',$data);
        }

        /**
         * Render the about view
        */
        public function about(){
            $data = ["title"=>"About Us"];
            $this->view('about',$data);
        }

        /**
         * The contact view
        */
        public function contact(){
            $data = ["title"=>"Contact Us"];
            $this->view('contact',$data);
        }
    }
