<?php

// Get the root directory of the project
$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

include_once $ROOT_PATH . '/src/CreateDB.php';

// read the db configuration and init the connection settings
$config = parse_ini_file($ROOT_PATH . '/config/config.ini');

$username = $config['db.username'];
$password = $config['db.password'];
$hostname = $config['db.hostname'];
$database = $config['db.database'];

$createDB = new CreateDB();

?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../style/styles.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Ropa+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>
<div style="overflow: hidden;width: 100%; height: 100%">
    <div class="bgImg"></div>    
</div>

<div class="pageContent">
    <div class="db_form">
        <div class="border start">
            Could not connect to the database.<br/>
            Please verify that the following is the right configuration. <br/>
            If the configuration is wrong edit the config/config.ini and update the right values <br/>
            <br/>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label for="username">User Name</label>
                <input id="username" name="username" type="text" value="<?php echo $username?>" readonly/>
                <br/>

                <label for="password">Password</label>
                <input id="password" name="password" type="text" value="<?php echo $password?>" readonly/>
                <br/>

                <label for="database">Databsea</label>
                <input id="database" name="database" type="text" value="<?php echo $database?>" readonly/>
                <br/>

                <label for="hostname">Host Name</label>
                <input id="hostname" name="hostname" type="text" value="<?php echo $hostname?>" readonly/>
                <br/>

                <span class="button orange medium" data-action="test" onclick="submitForm('test')">Test connection</span>
                <span class="button orange medium" data-action="create" onclick="submitForm('create')">Create db</span>
            </form>
        </div>
    </div>
</div>
<script src="../js/polyfills.js"></script>
<script>
    function submitForm(action) {
        document.getElementById('action').value = action;
        document.querySelector('form').submit();
    }
</script>
</body>
</html>


