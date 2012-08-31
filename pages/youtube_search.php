<?php

    use Moood\helpers\Utils;
    use Moood\User\Playlists;

    $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
    include_once $ROOT_PATH . '/src/bootstrap.php';

    $playlists = new Playlists();
    $songs = isset($_REQUEST['songs']) ? $_REQUEST['songs'] : null;

?>
<!DOCTYPE html >
<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>

    <link href="../style/style.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<div class="pageContent search">
    <?php include 'header.php' ?>

    <div class="main">

        <div class="searchToggle hidden">
            <a href="#">Show Search dialog</a>
        </div>

        <div class="dialogWrapper">
            <div class="dialog search">

                <img class="close" src="../images/close.png">

                <h1>
                    <img src="../images/search.png">Search Music
                </h1>

                <form method="POST" onsubmit="return false;">
                    <input type="hidden" name="action" id="action">

                    <label class="label" for="query">Search for: </label>
                    <input id="query" name="query" type="text" value="<?= Utils::getParam('query', '')?>"/>
                    <br/>

                    <label class="label" for="numberOfSongs">Number of songs</label>

                    <div class="slider">
                        <input class="bar" name="numberOfSongs" type="range" id="numberOfSongs"
                               value="<?= Utils::getParam('numberOfSongs', '10')?>" min="1" max="25"/>
                        <span class="rangeValue" id="rangeValue"><?= Utils::getParam('numberOfSongs', '10')?></span>

                    </div>

                    <br/>

                    <div class="buttons">
                        <span class="button orange" data-action="search" id="searchButton">Search</span>
                    </div>

                </form>
            </div>
            <br/>
        </div>

        <div class="spacer"></div>

        <div class="songsList">
            <?php include 'utils\songs_results.php' ?>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>

<script src="../js/polyfills.js"></script>
<script src="../js/Moood.js"></script>
<script src="../js/Search.js"></script>
<script>
    Moood.Search.init();
        <?= isset($songs) ? 'Moood.Search.toggleDialog()' : '' ?>
</script>

</body>
</html>