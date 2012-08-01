<?php
// Get the root directory of the project
$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

// read the db configuration and init the connection settings
$config = parse_ini_file($ROOT_PATH . '/config/config.ini');

$username = $config['db.username'];
$password = $config['db.password'];
$host = $config['db.host'];
$db_name = $config['db.dbname'];

?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../style/style.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Ropa+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>

<div class="pageContent">
    <div class="db_form">
        <div class="border start">
            Could not connect to the database.<br/>
            Please verify that the following is the right configuration. <br/>
            If the configuration is wrong edit the config/config.ini and update the right values <br/>
            <br/>

            <form>
                <label for="username">User Name</label>
                <input name="username" type="text" placeholder="<?php echo $username?>"/>
                <br/>

                <label for="password">Password</label>
                <input name="password" type="text" placeholder="<?php echo $password?>"/>
                <br/>

                <label for="pass">DB name</label>
                <input name="dbName" type="text" placeholder="<?php echo $db_name?>"/>
                <br/>

                <label for="pass">host</label>
                <input name="host" type="text" placeholder="<?php echo $host?>"/>
                <br/>

                <a href="#" class="button orange medium">Test connection</a>
                <a href="#" class="button orange medium">Create db</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>


