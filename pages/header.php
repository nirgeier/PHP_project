<header>
    <div class="logo">&nbsp;</div>
    <ul class="menuNav">

        <?php
        // Check to see if user is logged in already or not
        if (isset($_SESSION['userId'])) {
            ?>
            <li><a href="/pages/playlists.php">Playlists</a></li>
            <li><a href="/pages/details.php?action=update">Update Profile</a></li>
            <li><a href="/pages/login.php">Logout</a></li>

            <?
        } else {
            ?>
            <li><a href="/pages/details.php">Sign up</a></li>
            <? }?>
    </ul>
</header>
