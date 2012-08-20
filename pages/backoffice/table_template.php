<?php

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/common/includes.php';
    include_once $ROOT_PATH . '/src/Backoffice.php';

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();
    $_SESSION['records'] = $dbLayer->executeQuery('backoffice.users');

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../../style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent backoffice records">
    <?php include 'header.php' ?>

    <div class="main">
        <div class="dialog">

            List of <?= Utils::getParam('table_name') ?> in the system
            <?php include 'table_data.php'; ?>
        </div>
    </div>
</div>

</body>
</html>
