<?php
    /**
     * This view is for registering or update users.
     * Here user will create/update his profile information.
     *
     * If we are in update mode user can not update his username
     */

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    use Moood\User\UserActions;
    use Moood\helpers\Utils;

    // Execute the current action (if any)
    // In real application i will not do it this way,
    // i would have use Zend framework with views actions and forms.

    // We need to execute action only after the user has filled in the details.
    // we can know it by checking if there is a userId in the form
    if (Utils::getParam("id", null) != null) {
        $action = new UserActions();
        $action->processRequest();
    }

    // We use this page for registration and for updating the user details.
    // First of all check to see if this is a register or details page
    $isUpdate = isset($_GET['action']) && $_GET['action'] === 'update';

    // We use the same form for registration and for updating user information.
    // Find out if this is a registration or update action
    if ($isUpdate) {
        $userData = $_SESSION['user']->getUserData();
        $id = $userData['id'];
        $username = $userData['username'];
        $password = $userData['password'];

        $nick_name = $userData['nick_name'];
        $last_name = $userData['last_name'];
        $first_name = $userData['first_name'];
        $email = $userData['email'];
        $img = $userData['image'];

    } else {
        // Get the values if the form was already submitted
        $id = -1;
        $username = Utils::getParam('username', '');
        $password = Utils::getParam('password', '');

        $nick_name = Utils::getParam('nick_name', '');
        $last_name = Utils::getParam('last_name', '');
        $first_name = Utils::getParam('first_name', '');
        $email = Utils::getParam('email', '');
        $img = Utils::getParam('img', '/images/pixel.gif');
    }

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
<div class="pageContent users">
    <?php include '../header.php' ?>
    <div class="main">

        <div class="dialog">

            <div class="ajaxLoader animate hidden">
                <span>
                    <span></span>
                </span>
            </div>

            <? if ($isUpdate) { ?>
            <h1><img src="/images/profile.png" width="48">My Profile</h1>
            Here you can update your details.<br/>
            * Username cannot be updated.
            <? } else { ?>
            <h1>
                <img src="/images/signup.png">Sign up
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
                <img id="username_status" class="status_img hidden" src="/images/pixel.gif">

                <div class="inline_error hidden" id="username_error"></div>


                <label class="label required" for="password">Password</label>
                <input id="password" name="password" type="password" value="<?php echo $password?>"/>
                <img id="password_status" class="status_img hidden" src="/images/pixel.gif">

                <div class="inline_error hidden" id="password_error"></div>


                <label class="label required" for="password2">Verify Password</label>
                <input id="password2" name="password2" type="password" value="<?php echo $password?>"/>
                <img id="password2_status" class="status_img hidden" src="/images/pixel.gif">

                <div class="inline_error hidden" id="password2_error"></div>

                <div class="spacer"></div>

                <label class="label" for="email">Email</label>
                <input id="email" name="email" type="text" value="<?php echo $email?>"/>
                <img id="email_status" class="status_img hidden" src="/images/pixel.gif">

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
<?php include '../footer.php' ?>

<script src="/js/polyfills.js"></script>
<script src="/js/Moood.js"></script>
<?php  if (!$isUpdate) { ?>
<script src="/js/Register.js"></script>
    <? } else { ?>
<script>
    Moood.initForm();
</script>
    <? } ?>
</body>
</html>