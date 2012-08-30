<?php

    use Moood\User\Actions;

    // This file will simply execute the desired action.
    // It will contain no code. All the logic is inside the Actions class.
    // The file is invoked using Ajax
    include_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

    // Simply execute the action and return JSON as reply
    $users = new Actions();

?>