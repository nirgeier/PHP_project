<?php

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/includes.php';
    include_once $ROOT_PATH . '/src/classes/Backoffice.php';

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();

    $_REQUEST['records'] = $dbLayer->executeQuery(Utils::getParam('queryId'));

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
        <?php include '../utils/generate_table.php'; ?>
    </div>
</div>

</body>
</html>
