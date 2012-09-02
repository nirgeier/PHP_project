<?php
    /**
     * This view will display the user playlist.
     * The code in this file is not mapped to any class since this file is
     * user to display the playlist data.     *
     */

    use Moood\helpers\Utils;
    use Moood\DBLayer;
    use Moood\User\Playlist;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Check if we have errors or not
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
    $errorClass = isset($error) ? '' : 'hidden';

    // The playlist is the handler class for this view
    $playlist = new Playlist();

    // Process any request action if any.
    $playlist->processRequest();

    //Load the playlist for the current user
    $user = $_SESSION['user'];

    $dbLayer = DBLayer::getInstance();

    // Load the playlist data
    $records = $dbLayer->executeQuery('users.playlist.summary', array(':user_id' => $_SESSION['userId']));

    // Verify that the user has data.
    // If no data found we display a message telling the user to create new playlist.
    if (!isset($records) || count($records) == 0) {
        echo '<div class="empty">You did not created any playlist yet.<br/>Use the above button to do so.</div>';
        return;
    }
?>
<div class="spacer"></div>

<div class="dialog">

    <h1>
        <img src="/images/list.png" title="My Playlist">
        My Playlist
    </h1>
    <table class="data_table" cellpadding="0" cellspacing="0">
        <?php
        $keys = array_keys($records[0]);

        // Print the headers
        echo '<thead>';
        foreach ($keys as $key) {
            switch ($key) {
                case 'id':
                    echo '<th>Actions</th>';
                    break;
                default:
                    echo '<th>' . Utils::getTableHeader($key) . '</th>';
                    break;
            }
        }

        echo '</thead>';
        echo '<tbody>';

        foreach ($records as $record) {
            echo '<tr>';
            foreach ($keys as $key) {
                switch ($key) {
                    case 'id':
                        echo '<td class="center">';
                        echo '<img src="/images/trash_delete.png" title="delete" data-delete="' . $record[$key] . '">';
                        echo '&nbsp;<a href="/views/songs/youtube_search.php"><img src="/images/list_add.png" title="Search for more" data-search="" width="24px"></a>';
                        echo '&nbsp;<img src="/images/play_songs.png" title="Play songs" data-play="' . $record[$key] . '" data-name="' . $record['Name'] . '" width="24px">';
                        echo '</td>';
                        break;
                    default:
                        echo '<td>' . $record[$key] . '</td>';
                        break;

                }
            }
            // Add the action column icons
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>