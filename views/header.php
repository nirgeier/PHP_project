<header>
    <div class="logo">&nbsp;</div>
    <a class="admin" href="/views/backoffice/login.php"></a>

    <ul class="menuNav">

        <?php

        $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
        include_once $ROOT_PATH . '/src/bootstrap.php';

        // Check to see if user is logged in already or not
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user']->getUserData();
            ?>
            <li><a href="/views/songs/youtube_search.php"><img src="/images/search64.png" title="Search on YouTube"></a></li>
            <li><a href="/views/user/details.php?action=update">&nbsp;&nbsp;<img src="/images/profile.png" title="Edit my profile">&nbsp;&nbsp;</a></li>
            <li><a href="/views/playlist/playlist.php"><img src="/images/list.png" title="My Playlist"></a></li>
            <li><a href="/views/user/login.php"><img src="/images/logout.png" title="Logout"></a></li>
            <li class="user"><img src="<?= isset($user['image']) ? $user['image'] : '/images/pixel.gif' ?>" width="48px"><?= $user['username'] ?></li>
            <?
        } else {
            ?>
            <li><a href="/views/user/login.php"><img src="/images/login.png" title="Login"></a></li>
            <li><a href="/views/user/details.php"><img src="/images/signup.png" title="Sign up"></a></li>
        <? }?>

    </ul>
</header>
