<div class="spacer"></div>

<table>
    <tbody>
    <?php
        $i = 0;
        $records = $_SESSION['records'];

        if (isset($records)) {
            $keys = array_keys($records[0]);

            // Print the headers
            echo '<thead>';
            foreach ($keys as $key) {
                echo '<th>' . Utils::getTableHeader($key) . '</th>';
            }
            echo '</thead>';

            foreach ($records as $records) {
                echo '<tr>';
                foreach ($keys as $key) {

                    // Special case for isAdmin - we display image
                    switch ($key) {
                        case 'is_admin':
                            echo '<td class="center"><img src="../../images/' . ($records[$key] != 1 ? 'not_' : '') . 'ok.png" class="adminImg"></td>';
                            break;
                        case 'image':
                            echo '<td class="center"><img src="' . $records[$key] . '"></td>';
                            break;

                        default:
                            echo '<td>' . $records[$key] . '</td>';
                            break;
                    }


                }
                echo '</tr>';
            }
        }
    ?>
    </tbody>

</table>
