<?php

    use Moood\helpers\Utils;

    // Get the users playlist
    $user = $_SESSION['user'];
    $playlists = $user->getPlaylists();

    // Check to see that we have data in the playlist.
    if (count($playlists) == 0) {
        echo '<div class="noPlaylist"><a href="/pages/playlists.php">CLick here</a> to create playlist</div>';
        return;
    }
?>
<div class="playlist_dropdown" data-vid="<?= $song['videoId'] ?>">
    <label>Add to playlist:</label>
    <select class="playlists_list" data-vid="<?= $song['videoId'] ?>" data-title="<?= $song['title'] ?>">
        <option>&nbsp;</option>
        <?
        foreach ($playlists as $item) {
            echo '<option value="' . $item['id'] . '">' . $item['name'];
        }
        ?>
    </select>
    <div class="skew_small" id="message_<?= $song['videoId'] ?>"></div>
</div>
