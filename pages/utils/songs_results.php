<?php

    use Moood\helpers\Utils;

    /**
     * This file will print out the playlist songs so user can choose from the list
     */
    if (!isset($_REQUEST['songs'])) {
        return;
    }

    echo '<h1>Search results for: <span class="skew">' . Utils::getParam('query', '') . '</span></h1>';

    // Get the playlist content
    $songs = $_REQUEST['songs'];

    // Get the playlist HTML code

    // Print out the playlists
    foreach ($songs as $song) {

        // In real life i would have used templates here to generate the content.
        // I have digged into this list: http://www.webresourcesdepot.com/19-promising-php-template-engines/
        // But did not had enough time to play with it and test them out.
        ?>
    <div class="spacer"></div>
    <section class="dialog playlistEntry">
        <details open>
            <summary><?= $song['title']?></summary>
            <? include 'playlist_dropdown.php'; ?>
            <p><?= $song['content'] ?></p>
            <iframe id="ytplayer" type="text/html" width="480" height="292"
                    src="http://www.youtube.com/embed/<?= $song['videoId'] ?>?autoplay=0&origin=<?= $_SERVER['SERVER_NAME'] ?>"
                    frameborder="0"></iframe>
        </details>
    </section>

    <? } ?>
