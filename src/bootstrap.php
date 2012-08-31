<?php

    //
    //  This file is the application entry point (bootstrap).
    //  All the application views/views will include this file
    //

    //
    // Register the Moood auto loader. (using anonymous function)
    //
    spl_autoload_register(function ($className) {

        // Get the root directory of the project
        $className = DIRECTORY_SEPARATOR . str_replace(array('/', '\\', '_'), DIRECTORY_SEPARATOR, $className) . '.php';
        include_once $className;
    });

    if (!isset($_SESSION)) {
        session_start();
    }
    ;
    // Check to see if the user is logged in or not.
    // If user is not logged in and trying to load any page but login - redirect to login page
    //if (!isset($_SESSION['user']) &&
    //    (strcmp(basename($_SERVER['PHP_SELF']), 'index.php') == -1 || strcmp(basename($_SERVER['PHP_SELF']), 'details.php') == -1)
    //) {
    //    header('Location: /views/user/login.php');
    //}
