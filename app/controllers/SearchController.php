<?php

    class SearchController extends Controller{
        private $searchModel;

        public function __construct()
        {
            // Load the Search model
            $this->searchModel = new SearchModel();
        }

        /**
         * Handles the search functionality.
         * 
         * - Expects a POST request with a 'query' parameter.
         * - Validates and sanitizes the search input.
         * - Fetches the search results from the model.
         * - Returns the results in JSON format for AJAX or error messages for invalid queries.
         * 
         * @return void
         */
        public function search()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
                $query = sanitizeInput($_POST['query']);

                // Check if the query is not empty
                if (!empty($query)) {

                    $searchResults = $this->searchModel->search($query);

                    echo json_encode([
                        'success' => true,
                        'results' => $searchResults
                    ]);

                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Search query cannot be empty.'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid request. Please use the search form.'
                ]);
            }
        }

    }
