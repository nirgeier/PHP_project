<?php

    use Moood\User\Actions;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Clear the previous user info - if any
    $_SESSION['userId'] = null;
    $_SESSION['user'] = null;

    // Execute the desired action. All actions are defined inside the class CTOR
    $actions = new Moood\User\Actions();

    // Get the values if the form was already submitted
    $username = isset($_POST['username']) ? $_POST['username'] : 'nirgeier';
    $password = isset($_POST['password']) ? $_POST['password'] : '25357823';

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
<div class="pageContent login">
    <?php include 'header.php' ?>

    <div class="main">

        <div class="dialog login">
            <h1>
                <img src="../images/login.png">
                Login
            </h1>

            <div class="error <?= $errorClass ?>">
                <?= $error ?>
            </div>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label" for="username">User Name</label>
                <input id="username" name="username" type="text" value="<?php echo $username?>"/>
                <br/>

                <label class="label" for="password">Password</label>
                <input id="password" name="password" type="password" value="<?php echo $password?>"/>
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
                <a href="details.php">Join us</a>

            </form>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>

<script src="../js/polyfills.js"></script>
<script src="../js/Moood.js"></script>
<script>

    Moood.initForm();

    (function () {

        var valid,
            username = document.querySelector('#username'),
            password = document.querySelector('#password'),
            loginButton = document.querySelector('#loginButton'),
            tooltip = document.querySelector('.tooltip');

        function validate() {
            valid = true;

            // Check the username field
            valid &= username.value && username.value.length > 3;
            valid &= password.value && password.value.length > 6;

            // Set the disabled class
            loginButton.classList[valid ? 'remove' : 'add']('disabled');
            tooltip.classList[valid ? 'add' : 'remove']('hidden');
        }

        username.addEventListener('keydown', validate, false);
        password.addEventListener('keydown', validate, false);

    })();

</script>

</body>
</html>
