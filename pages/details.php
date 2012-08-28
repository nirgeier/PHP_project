<?php
    include_once '../src/bootstrap.php';

    use Moood\User\Actions;

    // Execute the current action (if any)
    // In real application i will not do it this way,
    // i would have use Zend framework with views actions and forms.
    new Actions();

    // We use this page for registration and for updating the user details.
    // First of all check to see if this is a register or details page
    $isUpdate = isset($_GET['action']) && $_GET['action'] === 'update';

    if ($isUpdate) {

        $details = $_SESSION['user']->getUserData();
        $id = $details['id'];
        $username = $details['username'];
        $password = $details['password'];

        $nick_name = $details['nick_name'];
        $last_name = $details['last_name'];
        $first_name = $details['first_name'];
        $email = $details['email'];
        $img = $details['image'];

    } else {
        // Get the values if the form was already submitted
        $id = -1;
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $nick_name = isset($_POST['nick_name']) ? $_POST['nick_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : 'nirgeier@gmail.com';
        $img = isset($_POST['img']) ? $_POST['img'] : '../images/pixel.gif';
    }

    // Check if we have errors or not
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
    $errorClass = isset($error) ? '' : 'hidden';
?>

<!DOCTYPE html >
<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>

    <link href="../style/style.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<div class="pageContent users">
    <?php include 'header.php' ?>
    <div class="main">

        <div class="dialog">

            <? if ($isUpdate) { ?>
            <h1><img src="../images/profile_edit.png">My Profile</h1>
            Here you can update your details.<br/>
            * Username cannot be updated.
            <? } else { ?>
            <h1>
                <img src="../images/signup.png">Sign up
            </h1>
            <a href="login.php">Click here</a> if you already have an account or
            Join now its <a class="highlight">Free</a> and get stuck with us for ever ....
            <br/>
            <? }?>

            <div class="error <?= $errorClass ?>" id="errorDiv">
                <?= $error ?>
            </div>

            <div class="spacer"></div>

            <form method="POST">
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id" value="<?= $id ?>">

                <label class="label required" for="username">User Name</label>
                <input id="username" name="username" type="text"
                       value="<?php echo $username?>" <?= $isUpdate ? 'disabled' : '' ?>/>
                <img id="username_status" class="status_img hidden" src="../images/pixel.gif">

                <div class="inline_error hidden" id="username_error"></div>


                <label class="label required" for="password">Password</label>
                <input id="password" name="password" type="password" value="<?php echo $password?>"/>
                <img id="password_status" class="status_img hidden" src="../images/pixel.gif">

                <div class="inline_error hidden" id="password_error"></div>


                <label class="label required" for="password2">Verify Password</label>
                <input id="password2" name="password2" type="password" value="<?php echo $password?>"/>
                <img id="password2_status" class="status_img hidden" src="../images/pixel.gif">

                <div class="inline_error hidden" id="password2_error"></div>

                <div class="spacer"></div>

                <label class="label" for="email">Email</label>
                <input id="email" name="email" type="text" value="<?php echo $email?>"/>
                <img id="email_status" class="status_img hidden" src="../images/pixel.gif">

                <div class="inline_error hidden" id="email_error"></div>


                <label class="label" for="nick_name">Nick Name</label>
                <input id="nick_name" name="nick_name" type="text" value="<?php echo $nick_name?>"/>


                <label class="label" for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" value="<?php echo $first_name?>"/>


                <label class="label" for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" value="<?php echo $last_name?>"/>


                <label class="label" for="img">Image</label>
                <input type="hidden" id="profile_image" name="image" value="<?php echo $img?>">
                <img id="img" src="<?php echo $img?>"/>


                <div class="ajaxLoader hidden"></div>

                <div class="gravatarDiv">
                        <span class="cssButtons">
                            <input type="checkbox" id="gravatar">
                            <span>Fetch details from <span
                                    class="highlight blink">Gravatar</span> [Email Required]</span>
                        </span>
                </div>

                <div class="buttons">

                    <?php if ($isUpdate) {
                    ?>
                    <span class="button orange" data-action="update" id="actionButton">Update</span>

                    <?
                } else {
                    ?>
                    <span class="button orange disabled" data-action="register" id="actionButton">Sign up
                        <span class="tooltip">
                            <span></span>
                            Please fill in the required fields in order to register
                        </span>
                    </span>
                    <? }?>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="../js/polyfills.js"></script>
<script src="../js/Moood.js"></script>
<?php  if (!$isUpdate) { ?>
<script src="../js/register.js"></script>
    <? } else { ?>
<script>
    Moood.initForm();
</script>
    <? } ?>
</body>
</html>