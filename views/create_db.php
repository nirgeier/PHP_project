<?php
    // ----------------------------------------------------
    // This page/view is used to get the database connection
    // properties and to create the DB when needed.
    //-------------------------------------------------------

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

    include_once '../src/Moood/CreateDB.php';

    // read the db configuration and init the connection settings
    $config = parse_ini_file($ROOT_PATH . '/config/config.ini');

    $username = $config['db.username'];
    $password = $config['db.password'];
    $hostname = $config['db.hostname'];
    $database = $config['db.database'];

    $createDB = new \Moood\CreateDB();
    $createDB->processRequest();

    // Check if we have errors or not
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
    $errorClass = isset($error) ? '' : 'hidden';
?>

<!DOCTYPE html >
<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>

    <link href="/style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent createDB">

    <div class="main">
        <div class="dialog">
            <div class="border start">
                Could not connect to the database.<br/>
                Please verify that the following values are correct.<br/>
                If not, edit the <span class="highlight">config/config.ini</span> with the right values <br/>
                <br/>

                <div class="error <?= $errorClass ?>">
                    <?= $error ?>
                </div>


                <form method="POST">
                    <input type="hidden" name="action" id="action">

                    <label for="username">User Name</label>
                    <input id="username" name="username" type="text" value="<?php echo $username?>" readonly/>
                    <br/>

                    <label for="password">Password</label>
                    <input id="password" name="password" type="text" value="<?php echo $password?>" readonly/>
                    <br/>

                    <label for="database">Database</label>
                    <input id="database" name="database" type="text" value="<?php echo $database?>" readonly/>
                    <br/>

                    <label for="hostname">Host Name</label>
                    <input id="hostname" name="hostname" type="text" value="<?php echo $hostname?>" readonly/>
                    <br/>

                    <span class="button orange medium" data-action="create"
                          onclick="submitForm('create')">Create db</span>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>


<script src="/js/polyfills.js"></script>
<script>
    function submitForm(action) {
    document.getElementById('action').value = action;
    document.querySelector('form').submit();
    }
</script>
</body>
</html>


