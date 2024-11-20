<?php 

    $isLoggedIn = false;
    if (session_status() == PHP_SESSION_NONE){
        
        session_start();

        if (isset($_SESSION['user_id'])){
            $isLoggedIn = true;
            $userId = $_SESSION['user_id'];
            $full_name = $_SESSION['user_name'];
        }

    }

    $Genre = new Genre();
    $genres_names = $Genre->getLimited(6); // 6 names

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo "AdaMov | ".@$title?>
    </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo CSS;?>bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>plyr.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo CSS;?>style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?php echo url()?>">
                            <img src="<?php echo IMAGES;?>logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li>
                                    <a href="<?php echo url('genres')?>">Genres<span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                    <?php foreach ($genres_names as $genre): ?>
                                        <li><a href="<?php echo url('genres/show/' . $genre['name']); ?>"><?php echo $genre['name']; ?></a></li>
                                    <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li><a href="<?=url("home/about")?>">About</a></li>
                                <li><a href="<?=url("home/contact")?>">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right d-flex align-items-center">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <?php if (!$isLoggedIn):?>
                            <a href="<?=url("auth/")?>"><span class="icon_profile"></span></a>
                        <?php else: ?>
                            <nav class="header__menu">
                                <ul>
                                    <li>
                                        <img 
                                            src="https://via.placeholder.com/100" 
                                            alt="Avatar"
                                            width="40"
                                            height="40"
                                            class="rounded-circle"
                                            style="cursor: pointer;"
                                        >
                                        <ul class="dropdown">
                                            <p class="py-2 pl-2">Welcome back <span class="bg-primary px-2 text-white rounded text-nowrap"><?=$full_name?></span></p>
                                            <li><a href="<?=url("user/profile")?>"> Profile</a></li>
                                            <li><a href="<?=url("user/favorites")?>"> Favorites</a></li>
                                            <li><a href="<?=url("user/settings")?>"> Settings</a></li>
                                            <li><a href="<?=url("auth/logout")?>"> Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header Section Begin  -->
