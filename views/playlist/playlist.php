<html>
<head>
    <meta charset='UTF-8'>
    <title>Music for your mood</title>
    <link href="/style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="pageContent">
    <?php include '../header.php'?>

    <div class="main playlist">

        <div class="buttons">
            <span class="button orange playlistToggle">Create new playlist</span>
        </div>

        <div class="dialogWrapper closed">
            <div class="dialog playlist">

                <img class="close" src="/images/close.png">

                <h1>
                    <img src="/images/list.png" width="48">New playlist
                </h1>

                <fieldset>
                    <legend>Playlist name</legend>
                    <input id="name" name="name" type="text" value=""/>

                    <div class="buttons">
                        <span class="button orange" id="buttonAdd" data-action="add">Add</span>
                    </div>

                </fieldset>
            </div>
        </div>

        <div id="playlistContent">
            <? include 'playlist_content.php'; ?>
        </div>

        <div id="songsContent"></div>
    </div>
</div>
<?php include '../footer.php' ?>

<script src="/js/polyfills.js"></script>
<script src="/js/Moood.js"></script>
<script src="/js/Playlist.js"></script>
<script>
    Moood.Playlist.init();
</script>

</body>
</html>
