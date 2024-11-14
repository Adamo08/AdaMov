<?php


    class GenresController extends Controller {
        public function index() {
            // Fetch genres from the database
            // Assuming you have a Genre model that interacts with the database
            $genreModel = new Genre();
            $genres = $genreModel->all();
            // Pass genres to a view
            $this->view('genres', ['genres' => $genres]);
        }
    }
