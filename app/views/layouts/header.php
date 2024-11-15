<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anime | Template</title>

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
                                <li><a href="<?php echo url('genres')?>">Genres<span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="<?php echo url('genres/action')?>">Action</a></li>
                                        <li><a href="<?php echo url('genres/adventure')?>">Adventure</a></li>
                                        <li><a href="<?php echo url('genres/comedy')?>">Comedy</a></li>
                                        <li><a href="<?php echo url('genres/fantasy')?>">Fantasy</a></li>
                                        <li><a href="<?php echo url('genres/romance')?>">Romance</a></li>
                                        <li><a href="<?php echo url('genres/sci-fi')?>">Sci-Fi</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?=url("blog")?>">Our Blog</a></li>
                                <li><a href="<?=url("contact")?>">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <a href="<?=url("auth/")?>"><span class="icon_profile"></span></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->