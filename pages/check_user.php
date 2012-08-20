<?php
    include_once '../src/common/includes.php';
    include_once '../src/Users.php';

    /**
     * This file will check to see if the desired username is free for registration or not.
     * This page will be called using Ajax from the register page
     */

    // Get the username
    $username = $_GET['username'];

    // The sql query that check for username
    $queryId = 'users.check_username';

    $dblayer = DBLayer::getInstance();

    $dblayer->executeQuery(queryId);



