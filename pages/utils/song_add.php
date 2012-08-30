<?php

    use Moood\User\Playlists;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Execute action if any
    new Playlists();