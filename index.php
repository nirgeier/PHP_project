<!DOCTYPE html >
<?php
    include_once '/src/common/includes.php';
    include_once '/src/Users.php';

    $users = new Users();

    // Get the values if the form was already submitted
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

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

        <a href="pages/login.php" style="font-size: 72px;">Login</a>
    </div>
</div>

</body>
</html>
