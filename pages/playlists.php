<?php

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/common/includes.php';
    include_once $ROOT_PATH . '/src/Users.php';

?>
<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../style/styles.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<div class="pageContent playlist">
    <?php include 'header.php' ?>
    <div class="main">
        Playlists .....
    </div>
</div>
<?php include 'footer.php' ?>
<script src="../js/polyfills.js"></script>
<script src="../js/script.js"></script>

</body>
</html>