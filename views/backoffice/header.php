<header>
    <div class="logo">&nbsp;</div>
    <ul class="menuNav">

        <?php
        // Check to see if user is logged in already or not
        if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
        ?>
        <li><a href="table_template.php?table_name=users&queryId=backoffice.users"><img src="/images/users.png"></a></li>
            <li><a href="/views/backoffice/login.php"><img src="/images/logout.png" title="Logout"></a></li>
        <? }?>

    </ul>
</header>
