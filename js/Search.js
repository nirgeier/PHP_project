// Check for namespace
var Moood = Moood || {};

(!function (moood) {

    var Search;

    // The ns is our namespace.
    Search = function () {

    };

    //
    Search.prototype = {

        constructor:Search,

        /**
         * Init the specific playlist form
         */
        init:function () {

            // Call the general init form method
            moood.initForm();

            // Listen to the range update, Update the display value
            $$('#numberOfSongs').onchange = function () {
                $$('#rangeValue').innerHTML = this.value;
            };

            // Set the current value if its not the right one
            $$('#numberOfSongs').onchange();

            // Listen to click on the close button + the toggle link
            $$('.close').onclick = $$('.searchToggle').onclick = this.toggleDialog;

            // Attach the add to playlist enent
            moood.bindEvents('.playlist_list', 'onchange', this.addSong);

            moood.bindEvents('#query', 'onkeyup', moood.submitForm);

        },

        /**
         * Toggle the search dialog
         */
        toggleDialog:function () {
            var dialog = $$('.dialogWrapper'),
                toggleText = $$('.searchToggle');
            dialog.classList.toggle('closed');
            toggleText.classList.toggle('hidden');

        },


        addSong:function (e) {
            // grab the button that was clicked
            var src = e.srcElement || e.target,
                videoId = src.dataset['vid'],
                title = src.dataset['title'],
                url = [],
                html = '<br/>Song was successfully added to: ';


            url.push('/views/songs/song_add.php');
            url.push('?action=addSong');
            url.push('&pId=' + src.value);
            url.push('&id=' + encodeURIComponent(videoId));
            url.push('&title=' + encodeURIComponent(title));

            Moood.ajax(url.join(''),
                function (reply) {
                    $('message_' + videoId).innerHTML = html + src[src.selectedIndex].text + ' playlist<br/>';
                });

        }


    };

    // Add the Playlist to our namespace
    moood.Search = new Search();

}.apply(Moood, [Moood]));
