<?php

    set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/ZendFramework-1.11.13');

    //
    // Register the Moood auto loader. (anonymous function)
    //
    spl_autoload_register(function ($className) {

        // Get the root directory of the project
        $className = DIRECTORY_SEPARATOR . str_replace(array('/', '\\', '_'), DIRECTORY_SEPARATOR, $className) . '.php';
        include_once $className;
    });

    if (!isset($_SESSION)) {
        session_start();
    }
