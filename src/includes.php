<?php

    // Get the root directory of the project
    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

    set_include_path(get_include_path() . PATH_SEPARATOR . $ROOT_PATH . '/ZendFramework-1.11.13');

    //
    // Register the classes auto loader. (anonymous function)
    //
    spl_autoload_register(function ($class) {

        include_once $ROOT_PATH . '/src/helpers/Utils.php';
        include_once $ROOT_PATH . '/src/classes/User.php';
        include_once $ROOT_PATH . '/src/classes/UserActions.php';
        include_once $ROOT_PATH . '/src/classes/Playlists.php';
        include_once $ROOT_PATH . '/src/classes/DBLayer.php';

    });

    if (!isset($_SESSION)) {
        session_start();
    }

