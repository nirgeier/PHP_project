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
<div class="playlist_dropdown">
    <label>Add to playlist:</label>
    <select class="playlists_list" data-url="<?= $song['href'] ?>">
        <option>&nbsp;</option>
        <?
        foreach ($playlists as $item) {
            echo '<option value="' . $item['id'] . '">' . $item['name'];
        }
        ?>
    </select><br/>
</div>
