<header>
    <div class="logo">&nbsp;</div>
    <ul class="menuNav">

        <?php
        // Check to see if user is logged in already or not
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user']->getUserData();
            ?>
            <li><a href="/pages/youtube_search.php"><img src="../images/search64.png" title="Search on YouTube"></a></li>
            <li><a href="/pages/details.php?action=update">&nbsp;&nbsp;<img src="../images/profile.png"title="Edit my profile">&nbsp;&nbsp;</a></li>
            <li><a href="/pages/playlists.php"><img src="../images/list.png" title="My Playlists"></a></li>
            <li><a href="/pages/login.php"><img src="../images/logout.png" title="Logout"></a></li>
            <li class="user"><img src="<?= isset($user['image']) ? $user['image'] : '../images/pixel.gif' ?>" width="48px"><?= $user['username'] ?></li>
            <?
        } else {
            ?>
            <li><a href="/pages/login.php"><img src="../images/login.png" title="Login"></a></li>
            <li><a href="/pages/details.php"><img src="../images/signup.png" title="Sign up"></a></li>
        <? }?>

    </ul>
</header>
