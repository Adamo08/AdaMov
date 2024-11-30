<?php

    // Server Paths (used for PHP includes and requires)
    define("DS", DIRECTORY_SEPARATOR);
    define("ROOT_PATH", dirname(__DIR__) . DS);
    define("APP", ROOT_PATH . 'app' . DS);
    define("CONFIG", APP . 'config' . DS);
    define("CONTROLLERS", APP . 'controllers' . DS);
    define("CORE", APP . 'core' . DS);
    define("EMAIL", APP . 'email' . DS);
    define("LIBS", APP . 'libs' . DS);
    define("MODELS", APP . 'models' . DS);
    define("VIEWS", APP . 'views' . DS);
    define("ADMINVIEWS", APP . 'views' . DS.'admin'.DS);
    define("PUBL", ROOT_PATH . 'public' . DS);

    // URL Paths (used for linking assets in HTML)
    define("BASE_URL", '/AdaMov/public/');
    define("ASSETS", BASE_URL . 'assets/');
    define("ADMINASSETS", BASE_URL . 'assets/admin/');
    define("IMAGES", ASSETS . 'images/');
    define("AVATARS", ASSETS . 'avatars/');
    define("VIDEOS", ASSETS . 'videos/');
    define("CSS", ASSETS . 'css/');
    define("FONTS", ASSETS . 'fonts/');
    define("JS", ASSETS . 'js/');
    define("SASS", ASSETS . 'sass/');



require_once(CONFIG.'config.php');
require_once(CONFIG.'helpers.php');



// autoload all classes 
$modules = [ROOT_PATH,APP,CORE,EMAIL,LIBS,VIEWS,CONTROLLERS,MODELS,CONFIG,PUBL,ASSETS,IMAGES,CSS,FONTS,JS,SASS,VIDEOS,ADMINASSETS];
set_include_path(get_include_path(). PATH_SEPARATOR.implode(PATH_SEPARATOR,$modules));
spl_autoload_register('spl_autoload'); // false




new App();
