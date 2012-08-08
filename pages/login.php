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
            <h1>Login</h1>

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
                    <span class="button orange" data-action="login">Login</span>
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
</script>

</body>
</html>
