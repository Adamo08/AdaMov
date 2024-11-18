<?php

    class GenresController extends Controller {
        /**
         * Display all genres.
         */
        public function index() {
            $this->view('genres', [
                'title' => "Genres",
                'category' => null
            ]);
        }

        /**
         * Display a specific genre.
         *
         * @param string $genre The name of the genre.
         */
        public function show($genre) {
            $title = ucfirst($genre);
            $this->view('genres', [
                'title' => $title,
                'category' => $genre
            ]);
        }
    }


