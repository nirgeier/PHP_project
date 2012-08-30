<?php
    use Moood\helpers\Utils;

    $i = 0;
    $records = $_REQUEST['records'];

    if (!isset($records) || count($records) == 0) {
        return;
    }
?>
<div class="spacer"></div>

<div class="dialog">

    Content of <span class="table_name"><?= Utils::getParam('table_name') ?> </span>

    <div class="spacer"></div>
    <table class="data_table" cellpadding="0" cellspacing="0">
        <?php
        $keys = array_keys($records[0]);

        // Print the headers
        echo '<thead>';
        foreach ($keys as $key) {
            echo '<th>' . Utils::getTableHeader($key) . '</th>';
        }
        echo '</thead>';
        echo '<tbody>';

        foreach ($records as $record) {
            echo '<tr>';
            foreach ($keys as $key) {

                // Special case for isAdmin - we display image
                switch ($key) {
                    case 'is_admin':
                        echo '<td class="center"><img src="../../images/' . ($record[$key] != 1 ? 'not_' : '') . 'ok.png" class="adminImg"></td>';
                        break;
                    case 'image':
                        echo '<td class="center"><img src="' . $record[$key] . '"></td>';
                        break;

                    default:
                        echo '<td>' . $record[$key] . '</td>';
                        break;
                }


            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>


