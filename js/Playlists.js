// Check for namespace
var Moood = Moood || {};

(!function (moood) {

    var Playlists;

    // The ns is our namespace.
    Playlists = function () {

    };

    //
    Playlists.prototype = {

        constructor:Playlists,

        /**
         * Init the specific playlist form
         */
        init:function () {
            // Listen to click on the close button + the toggle link
            $$('.close').onclick = $$('.playlistToggle').onclick = this.toggleDialog;

            // Set the button listener
            $('buttonAdd').onclick = this.addPlaylist;

            this.attachEvents();
        },

        attachEvents:function () {

            moood.bindEvents('[data-delete]', 'onclick', this.deletePlaylist);
            moood.bindEvents('[data-search]', 'onclick', this.redirectToSearch);

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
            Moood.ajax('../pages/utils/playlist_content.php?action=add&name=' + $('name').value,
                function (reply) {
                    $('playlistsContent').innerHTML = reply;
                    moood.Playlists.attachEvents();
                });
        },

        deletePlaylist:function (e) {

            // grab the button that was clicked
            var src = e.srcElement || e.target,
                pId = src.dataset['delete'];

            Moood.ajax('../pages/utils/playlist_content.php?action=delete&pId=' + pId,
                function (reply) {
                    $('playlistsContent').innerHTML = reply;
                    moood.Playlists.attachEvents();
                });
        },

        redirectToSearch:function () {
            window.location.href = '/pages/youtube_search.php';
        }

    };

    // Add the Playlist to our namespace
    moood.Playlists = new Playlists();

}.apply(Moood, [Moood]));
