<!DOCTYPE html >
<?php
    include_once '../src/common/includes.php';
    include_once '../src/Users.php';

    $users = new Users();

    // Get the values if the form was already submitted
    $username = isset($_POST['username']) ? $_POST['username'] : 'nirgeier';
    $password = isset($_POST['password']) ? $_POST['password'] : '25357823';

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="/style/style.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Ropa+Sans&subset=latin,latin-ext' rel='stylesheet'
          type='text/css'>
</head>

<body>
<div class="pageContent login">
    <div class="main">

        <div class="dialog login">
            <h1>
                <img src="../images/logo_48.png" class="loginImg">
                Login
            </h1>

            <div class="spacer"></div>
            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label" for="username">User Name</label>
                <input id="username" name="username" type="text" value="<?php echo $username?>"/>
                <br/>

                <label class="label" for="password">Password</label>
                <input id="password" name="password" type="text" value="<?php echo $password?>"/>
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
                <a href="register.php">Join us</a>

            </form>
        </div>
    </div>
</div>
<script src="../js/polyfills.js"></script>
<script src="../js/script.js"></script>
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
