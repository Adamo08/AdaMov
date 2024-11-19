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
            $this->prepareURL($_SERVER['QUERY_STRING']);
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

            if (!empty($url)) {
                $url = explode('/', $url);
                // Define controller 
                $this->controller = isset($url[0]) ? ucwords($url[0]) . "Controller" : "HomeController";
                // Define method
                $this->action = isset($url[1]) ? $url[1] : "index";

                unset($url[0], $url[1]);

                // Set params
                $this->params = !empty($url) ? array_values($url) : [];
            }
        }

        /**
         * Render controller, method, and send parameters 
         * @return void
         */
        private function render()
        {
            // Check if the controller exists
            if (class_exists($this->controller)) {
                $controller = new $this->controller;

                // Check if the method exists in the controller
                if (method_exists($controller, $this->action)) {
                    call_user_func_array([$controller, $this->action], $this->params);
                } else {
                    // Method does not exist, load error view with message
                    $this->loadErrorView("Method '{$this->action}' not found in controller '{$this->controller}'");
                }
            } else {
                // Controller does not exist, load error view with message
                $this->loadErrorView("Controller '{$this->controller}' not found");
            }
        }

        /**
         * Load error view
         * @param string $message Error message to display
         * @return void
         */
        private function loadErrorView($message)
        {
            // Pass the error message to the view
            new View('error', ['message' => $message]);
        }
    }

