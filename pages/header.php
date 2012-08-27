<header>
    <div class="logo">&nbsp;</div>
    <ul class="menuNav">

        <?php
        // Check to see if user is logged in already or not
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user']->getUserData();
            ?>
            <li><a href="/pages/youtube_search.php"><img src="../images/youtube.png" alt="Search on YouTube" class="youtubeImg"></a></li>
            <li><a href="/pages/playlists.php">My Playlists</a></li>
            <li><a href="/pages/details.php?action=update"><img src="<?= isset($user['image']) ? $user['image'] : '../images/pixel.gif' ?>" width="32px"><?= $user['username'] ?></a></li>
            <li><a href="/pages/login.php"><img src="../images/exit.png" alt="Logout">&nbsp;Logout</a></li>

            <?
        } else {
            ?>
            <li><a href="/pages/login.php">Login</a></li>
            <li><a href="/pages/details.php">Sign up</a></li>
            <? }?>
    </ul>
</header>
