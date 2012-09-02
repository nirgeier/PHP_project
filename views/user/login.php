<?php

    use Moood\Bootstrap;
    use Moood\helpers\Utils;
    use Moood\User\UserActions;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // The instance of the class that responsible of processing this page actions
    $actions = new UserActions();

    // First of all logout the current user since we are in the login page
    $actions->logout();

    // Now process the given action
    $actions->processRequest();

    // Check if we have errors or not
    $error = Utils::getParam('error', null);
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
<div class="pageContent login">
    <?php include '../header.php' ?>

    <div class="main">

        <div class="dialog login">
            <h1>
                <img src="/images/login.png">
                Login
            </h1>

            <div class="error <?= $errorClass ?>">
                <?= $error ?>
            </div>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label" for="username">User Name</label>
                <input id="username" name="username" type="text"
                       value="<?php echo Utils::getParam('username', '')?>"/>
                <br/>

                <label class="label" for="password">Password</label>
                <input id="password" name="password" type="password"
                       value="<?php echo Utils::getParam('password', '')?>"/>
                <br/>

                <div class="buttons">
                    <span class="button orange disabled" data-action="login" id="loginButton">Login
                        <span class="tooltip hidden">
                            <span></span>
                            Please fill in the required fields, before you can login
                        </span>
                    </span>
                </div>

                <div class="spacer"></div>

                Not a member yet ?
                <a href="/views/user/details.php">Join us</a>

            </form>
        </div>
    </div>
</div>
<?php include '../footer.php' ?>

<script src="/js/polyfills.js"></script>
<script src="/js/Moood.js"></script>
<script src="/js/Login.js"></script>

</body>
</html>
