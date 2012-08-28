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
            $$('.close').onclick = $$('.searchToggle').onclick = this.toggleSearchDialog;
        },

        /**
         * Toggle the search dialog
         */
        toggleSearchDialog:function () {
            var dialog = $$('.dialogWrapper'),
                toggleText = $$('.searchToggle');
            dialog.classList.toggle('closed');
            toggleText.classList.toggle('hidden');

        }


    };

    // Add the Playlist to our namespace
    moood.Search = new Search();

}.apply(Moood, [Moood]));
