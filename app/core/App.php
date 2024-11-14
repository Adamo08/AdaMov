<?php 



    class App 
    {
        // controller
        protected $controller = "HomeController";
        // method 
        protected $action = "index";
        // params 
        protected $params = []; // additional params

        public function __construct()
        {
            // Print the query string for debugging
            // echo "QUERY_STRING: " . $_SERVER['QUERY_STRING']; 
            $this->prepareURL($_SERVER['QUERY_STRING']);
            
            // Debug: Check controller, action, and params
            // echo "Controller: " . $this->controller . "<br>";
            // echo "Action: " . $this->action . "<br>";
            // echo "Params: <pre>"; print_r($this->params); echo "</pre>";
            
            // invoke controller and method
            $this->render();
        }

        /**
         * Extract controller, method, and all parameters
         * @param string $url -> request from url path
         * @return void
         */
        private function prepareURL($url)
        {
            $url = trim($url, "/");

            // Debug: Show the raw URL input
            // echo "Raw URL: $url <br>";

            if (!empty($url)) {
                $url = explode('/', $url);
                // Define controller 
                $this->controller = isset($url[0]) ? ucwords($url[0]) . "Controller" : "HomeController";
                // Define method
                $this->action = isset($url[1]) ? $url[1] : "index";

                // Debug: Show the controller and action extracted from the URL
                // echo "Extracted Controller: " . $this->controller . "<br>";
                // echo "Extracted Action: " . $this->action . "<br>";

                // Remove controller and action from the URL, leaving parameters
                unset($url[0], $url[1]);

                // Set params
                $this->params = !empty($url) ? array_values($url) : [];

                // Debug: Show the parameters
                // echo "Params after processing: <pre>"; print_r($this->params); echo "</pre>";
            }
        }

        /**
         * Render controller, method, and send parameters 
         * @return void
         */
        private function render()
        {
            // Debug: Check if the controller class exists
            // echo "Checking if controller class exists: " . $this->controller . "<br>";

            if (class_exists($this->controller)) {
                $controller = new $this->controller;
                
                // Debug: Check if the method exists in the controller
                // echo "Checking if method exists: " . $this->action . "<br>";

                if (method_exists($controller, $this->action)) {
                    // Debug: Method exists, now call it
                    // echo "Calling method: " . $this->action . "<br>";
                    call_user_func_array([$controller, $this->action], $this->params);
                } else {
                    // Method does not exist, load error view
                    // echo "Method does not exist.<br>";
                    $this->loadErrorView();
                }
            } else {
                // Controller does not exist, load error view
                // echo "Controller does not exist.<br>";
                $this->loadErrorView();
            }
        }

        /**
         * Load error view
         * @return void
         */
        private function loadErrorView()
        {
            // Log the error or provide an error message for debugging
            // echo "Error: The requested controller or method does not exist.";
            new View('error');
        }
    }

