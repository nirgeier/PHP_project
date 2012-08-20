<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get the root directory of the project
    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

    include_once $ROOT_PATH . '/src/Utils.php';
    include_once $ROOT_PATH . '/src/DBLayer.php';

    // Get the DB instance, check if the DB exists and redirect to the right page.
    DBLayer::getInstance();

