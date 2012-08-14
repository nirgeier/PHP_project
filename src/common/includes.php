<?php
    session_start();

    // Get the root directory of the project
    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

    include_once $ROOT_PATH . '/src/Utils.php' ;
    include_once $ROOT_PATH . '/src/DBLayer.php';
