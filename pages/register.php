<?php
include_once '../src/common/includes.php';
include_once '../src/Users.php';

$users = new Users();

// Get the values if the form was already submitted
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$nick_name = isset($_POST['nick_name']) ? $_POST['nick_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : 'nirgeier@gmail.com';
$img = isset($_POST['img']) ? $_POST['img'] : '../images/pixel.gif';

?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Music for your mood</title>

    <link href="../style/styles.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Ropa+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="pageContent users">
    <?php include 'header.php' ?>
    <div class="main">

        <div class="dialog">
            <img src="../images/signup.png" class="signupImg">

            <a href="login.php">Click here</a> if you already have an account or
            Join now its <a class="highlight">Free</a> and get stuck with us for ever ....
            <br/>
            <br/>

            <form method="POST">
                <input type="hidden" name="action" id="action">

                <label class="label reuqired" for="username">User Name</label>
                <input id="username" name="username" type="text" value="<?php echo $username?>"/>
                <br/>

                <label class="label reuqired" for="password">Password</label>
                <input id="password" name="password" type="text" value="<?php echo $password?>"/>
                <br/>

                <label class="label reuqired" for="password2">Verify Password</label>
                <input id="password2" name="password2" type="text" value="<?php echo $password?>"/>
                <br/>

                <div class="spacer"></div>

                <label class="label" for="email">Email</label>
                <input id="email" name="email" type="text" value="<?php echo $email?>"/>
                <br/>

                <label class="label" for="nick_name">Nick Name</label>
                <input id="nick_name" name="nick_name" type="text" value="<?php echo $nick_name?>"/>
                <br/>

                <label class="label" for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" value="<?php echo $first_name?>"/>
                <br/>

                <label class="label" for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" value="<?php echo $last_name?>"/>
                <br/>

                <label class="label" for="img">Image</label>
                <img id="img" src="<?php echo $img?>"/>
                <br/>

                <div class="ajaxLoader hidden"></div>

                <div class="gravatarDiv">
                        <span class="cssButtons">
                        <label>
                            <input type="checkbox" id="gravatar">
                            <span>Fetch details from <span
                                class="highlight blink">Gravatar</span> [Email Required]</span>
                        </label>
                        </span>
                </div>
                <br/>

                <div class="buttons">
                    <span class="button orange" data-action="register">Sign up</span>
                </div>
            </form>
        </div>

    </div>
</div>
<?php include 'footer.php' ?>

<script src="../js/polyfills.js"></script>
<script src="../js/script.js"></script>
<script>

    Moood.initForm();

    // This is a specific function for this page.
    // It will grab teh user details form Gravatar if the email is registered there.
    function checkGravatar(e) {
        var checkbox = e.srcElement;

        if (checkbox.checked) {
            //$$('.gravatarDiv').classList.add('hidden');
            $$('.ajaxLoader').classList.remove('hidden');

            Moood.ajax('/src/fetch_gravatar.php?email=' + $('email').value,
                function (info) {

                    var details;
                    $$('.ajaxLoader').classList.add('hidden');

                    if (info) {
                        details = JSON.parse(info).entry[0];
                        console.log(details);
                        $('nick_name').value = (details.preferredUsername || '');
                        $('username').value = (details.displayName || '');
                        $('img').src = (details.thumbnailUrl || '');
                    }
                });
        }
    }

    $('gravatar').onchange = checkGravatar;

</script>
</body>
</html>


