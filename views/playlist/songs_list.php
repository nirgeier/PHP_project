<?php

    use Moood\helpers\Utils;
    use Moood\DBLayer;
    use Moood\User\Playlist;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Execute action if any
    $actions = new Playlist();
    $actions->processRequest();

    /**
     * This file will print out the playlist songs so user can choose from the list
     */
    if (!isset($_REQUEST['songs'])) {
        return;
    }

    echo '<h1><span class="skew">' . Utils::getParam('name') . '</span></h1>';

    // Get the playlist content
    $songs = $_REQUEST['songs'];

    // Get the playlist HTML code

    // Print out the playlist
    foreach ($songs as $song) {
        ?>
    <div class="spacer"></div>
    <section class="dialog playlistSongs">
        <details>
            <summary><?= $song['title']?></summary>
            <iframe id="ytplayer" type="text/html" width="920" height="560"
                    src="http://www.youtube.com/embed/<?= $song['video_id'] ?>?autoplay=0&origin=<?= $_SERVER['SERVER_NAME'] ?>"
                    frameborder="0"></iframe>
        </details>
    </section>

    <? } ?>

<br/><br/><br/>