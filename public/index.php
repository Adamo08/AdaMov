<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once "autoload.php";

    // echo $_SERVER['QUERY_STRING'];
    // echo "<br>";
    // echo "<br>";
    // echo $_SERVER['REQUEST_URI'];

