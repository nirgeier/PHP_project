<!DOCTYPE html >
<?php

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/common/includes.php';
    include_once $ROOT_PATH . '/src/Backoffice.php';

    $backOffice = new Backoffice();

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../../style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent login">
    <?php include 'header.php' ?>

    <div class="main">

        <div class="dialog login">
            <h1>
                <img src="../../images/logo_48.png" class="loginImg">
                Backoffice
            </h1>

            <div class="spacer"></div>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label" for="username">User Name</label>
                <input id="username" name="username" type="text" value="nirgeier"/>
                <br/>

                <label class="label" for="password">Password</label>
                <input id="password" name="password" type="password" value="25357823"/>
                <br/>

                <div class="buttons">
                    <span class="button orange" data-action="login" id="loginButton">Login</span>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="../../js/polyfills.js"></script>
<script src="../../js/script.js"></script>
<script>

    Moood.initForm();

</script>

</body>
</html>
