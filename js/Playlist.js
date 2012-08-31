// Check for namespace
if (typeof Moood === 'undefined') {
    Moood = {};
}

(!function (moood) {

    var Playlist;

    // The ns is our namespace.
    Playlist = function () {

    };

    //
    Playlist.prototype = {

        constructor:Playlist,

        /**
         * Init the specific playlist form
         */
        init:function () {

            moood.initForm();

            // Listen to click on the close button + the toggle link
            $$('.close').onclick = $$('.playlistToggle').onclick = this.toggleDialog;

            // Set the button listener
            $('buttonAdd').onclick = this.addPlaylist;

            this.attachEvents();
        },

        attachEvents:function () {

            moood.bindEvents('[data-delete]', 'onclick', this.deletePlaylist);
            moood.bindEvents('[data-play]', 'onclick', this.showSongs);

            moood.bindEvents('#name', 'onkeyup', moood.submitForm);
        },

        /**
         * Toggle the search dialog
         */
        toggleDialog:function () {
            var dialog = $$('.dialogWrapper'),
                button = $$('.playlistToggle');
            dialog.classList.toggle('closed');
            button.classList.toggle('hidden');
        },

        /**
         * Add new playlist
         */
        addPlaylist:function () {
            Moood.ajax('/views/playlist/playlist_content.php?action=add&name=' + $('name').value,
                function (reply) {
                    $('playlistContent').innerHTML = reply;
                    moood.Playlist.attachEvents();
                });
        },

        deletePlaylist:function (e) {

            // grab the button that was clicked
            var src = e.srcElement || e.target,
                pId = src.dataset['delete'];

            Moood.ajax('/views/playlist/playlist_content.php?action=delete&pId=' + pId,
                function (reply) {
                    $('playlistContent').innerHTML = reply;
                    $('songsContent').innerHTML = '';
                    moood.Playlist.attachEvents();
                });
        },

        showSongs:function (e) {
            // grab the button that was clicked
            var src = e.srcElement || e.target,
                pId = src.dataset['play'],
                name = src.dataset['name'];

            Moood.ajax('/views/playlist/songs_list.php?action=songs_list&pId=' + pId + '&name=' + name,
                function (reply) {
                    $('songsContent').innerHTML = reply;
                });
        }

    };

    // Add the Playlist to our namespace
    moood.Playlist = new Playlist();

}.apply(Moood, [Moood]));
