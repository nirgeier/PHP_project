<?php
    /** This file will display the user playlists */

    use Moood\helpers\Utils;
    use Moood\DBLayer;
    use Moood\User\Playlists;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    // Check if we have errors or not
    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
    $errorClass = isset($error) ? '' : 'hidden';

    // Execute action if any
    new Playlists();

    //Load the playlists for the current user
    $user = $_SESSION['user'];

    // Load the table data that we need
    $dbLayer = DBLayer::getInstance();

    $records = $dbLayer->executeQuery('users.playlists.summary', array(':user_id' => $_SESSION['userId']));

    $i = 0;

    if (!isset($records) || count($records) == 0) {
        return;
    }
?>
<div class="spacer"></div>

<div class="dialog">

    <h1>
        <img src="../images/list.png" title="My Playlists">
        My Playlists
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
                        echo '<img src="../images/trash_delete.png" title="delete" data-delete="' . $record[$key] . '">';
                        echo '&nbsp;<img src="../images/list_add.png" title="Search for more" data-search="" width="24px">';
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