<?php
    /** This file will display the user playlists */

    use Moood\helpers\Utils;
    use Moood\DBLayer;
    use Moood\User\Playlists;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Execute action if any
    new Playlists();

    //Load the playlists for the current user
    $user = $_SESSION['user'];

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();

    $dbLayer->executeQuery('users.playlists.add', array(':user_id' => $_SESSION['userId']));
