<?php

    use Moood\DBLayer;
    use Moood\helpers\Utils;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();

    $_REQUEST['records'] = $dbLayer->executeQuery(Utils::getParam('queryId'));

?>
<!DOCTYPE html >
<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>

    <link href="/style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent backoffice records">
    <?php include '../header.php' ?>

    <div class="main">
        <?php include '../utils/generate_table.php'; ?>
    </div>
</div>

</body>
</html>
