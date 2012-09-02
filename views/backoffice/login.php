<!DOCTYPE html>
<?php

    use Moood\Backoffice;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Clear the previous user info - if any
    $_SESSION['userId'] = null;
    $_SESSION['user'] = null;

    $backOffice = new Backoffice();

?>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>

    <link href="../../style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<div class="pageContent login clearfix">
    <?php include '../header.php' ?>

    <div class="main">

        <div class="dialog login">
            <h1>
                <img src="/images/security_camera.png" width="64px"">
                Backoffice
            </h1>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label" for="username">User Name</label>
                <input id="username" name="username" type="text" value=""/>
                <br/>

                <label class="label" for="password">Password</label>
                <input id="password" name="password" type="password" value=""/>
                <br/>

                <div class="buttons">
                    <span class="button orange" data-action="login" id="loginButton">Login</span>
                </div>

            </form>
        </div>
    </div>
</div>
<?php include '../footer.php' ?>

<script src="../../js/polyfills.js"></script>
<script src="../../js/Moood.js"></script>
<script>

    Moood.initForm();

</script>

</body>
</html>
