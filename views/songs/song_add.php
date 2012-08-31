<?php

    /**
     * This file is called by Ajax request.
     * No logic need to be done here all is inside the Playlist handler
     */

    use Moood\User\Playlist;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Execute action if any
    $action = new Playlist();
    $action->processRequest();