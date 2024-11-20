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

    /**
     * Converts total seconds or minutes into a human-readable time difference string.
     * @param int $totalSeconds Total seconds since the comment was created.
     * @return string Human-readable time difference (e.g., "2 hours ago", "5 days ago").
    */
    function getTimeAgo($totalSeconds) {
        $minutes = floor($totalSeconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $weeks = floor($days / 7);
        $months = floor($days / 30);
        $years = floor($days / 365);

        if ($minutes < 1) {
            return "just now";
        } elseif ($minutes < 60) {
            return "$minutes minute" . ($minutes > 1 ? "s" : "") . " ago";
        } elseif ($hours < 24) {
            return "$hours hour" . ($hours > 1 ? "s" : "") . " ago";
        } elseif ($days < 7) {
            return "$days day" . ($days > 1 ? "s" : "") . " ago";
        } elseif ($weeks < 4) {
            return "$weeks week" . ($weeks > 1 ? "s" : "") . " ago";
        } elseif ($months < 12) {
            return "$months month" . ($months > 1 ? "s" : "") . " ago";
        } else {
            return "$years year" . ($years > 1 ? "s" : "") . " ago";
        }
    }

