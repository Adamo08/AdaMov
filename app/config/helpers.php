<?php 

    // define routes 
    function url($url='')
    {
        echo SITE_NAME.$url;
    }

    // redirect
    function redirect($url)
    {
        return  SITE_NAME.$url;
    }

    function getCurrentDate() {
        return date("l j F Y"); 
    }

    function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    function generateRandomToken(){
        return bin2hex(random_bytes(16));
    }

    function displayRating($movieId) {
        $Review = new Review();
        for($i = 0; $i < $Review->getTotalRating($movieId); $i++) {
            echo "<i class='fa fa-star'></i>";
        }
    }