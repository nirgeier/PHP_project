<?php
    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/common/bootstrap.php';
    include_once $ROOT_PATH . '/src/MooodBackoffice.phpce.php';


    /**
     * This file will get the You Tube songs list for the given search term.
     * Once we have the list we will display it on screen so user can select which songs he wish to add to his playlists
     *
     * In real life i would have done it Client Side (JavaScript) but its done here in order to learn how to use JSON with PHP
     */

    // Get the params we need
    $searchTerm = urlencode(Utils::getParam('query', 'Pink Floyd'));
    $numberOfRecords = Utils::getParam('numberOfRecords', 25);

    // Get the playlist data from you tube
    $url = 'http://gdata.youtube.com/feeds/api/videos?alt=json&max-results=' . $numberOfRecords . '&format=5&q=' . $searchTerm;

    // Get the playlist data
    $json = file_get_contents($url);

?>
<script type="text/javascript">
    console.log(<?= $json ?>);

</script>