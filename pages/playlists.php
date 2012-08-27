<?php
    /** This file will display the user playlists */

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/includes.php';

    //Load the playlists for the current user
    $user = $_SESSION['user'];

    // Check if we have errors or not
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
    $errorClass = isset($error) ? '' : 'hidden';

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();

    $_REQUEST['records'] = $dbLayer->executeQuery('users.playlists', array(':user_id' => $_SESSION['userId']));

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>
    <link href="/style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent playlists">
    <?php include 'header.php' ?>

    <div class="main playlists">

        <div class="buttons">
            <span class="button orange" data-action="create">Create new playlist</span>
        </div>
        <?php
        // load the user playlists.
        // We currently already have it in the $user->getPlaylists()
        // but i decided to do it this way to demonstrate how the DBLayer extract the params from the
        // url and executing the query :-)
        include 'utils/generate_table.php';
        ?>

    </div>
    <?php include 'footer.php' ?>
</div>

<script src="../js/polyfills.js"></script>
<script src="../js/Moood.js"></script>
<script>

    Moood.initForm();

</script>

</body>
</html>
