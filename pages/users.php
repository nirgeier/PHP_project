<?php
    include_once '../src/common/includes.php';
    include_once '../src/Users.php';

    $users = new Users();

?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../style/styles.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Ropa+Sans&subset=latin,latin-ext' rel='stylesheet'
          type='text/css'>
</head>

<body>
<div class="pageContent">
    <?php include 'header.php' ?>
    <div class="main">
        <div class="dialog">
            <div class="border start">
                Could not connect to the database.<br/>
                Please verify that the following is the right configuration. <br/>
                If the configuration is wrong edit the <span class="highlight">config/config.ini</span> and update the right values <br/>
                <br/>

                <form method="POST">
                    <input type="hidden" name="action" id="action">

                    <label for="username">User Name</label>
                    <input id="username" name="username" type="text" value="<?php echo $username?>" readonly/>
                    <br/>

                    <label for="password">Password</label>
                    <input id="password" name="password" type="text" value="<?php echo $password?>" readonly/>
                    <br/>

                    <span class="button orange medium" data-action="test"
                          onclick="submitForm('test')">Test connection</span>
                    <span class="button orange medium" data-action="create"
                          onclick="submitForm('create')">Create db</span>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>

<script src="../js/polyfills.js"></script>
<script>
    function submitForm(action) {
        document.getElementById('action').value = action;
        document.querySelector('form').submit();
    }
</script>
</body>
</html>


