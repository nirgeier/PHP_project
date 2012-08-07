/**
 * This is the main script for the project
 */

// Check for namespace
var Moood = Moood || {};


// Common method shortcuts
function $(id){
    return document.getElementById(id);
}
function $$( selector ){
    return document.querySelector(selector);
}

Moood = function () {

    return{

        /**
         * This method will init the forms in pages.
         * It will setup the action defined in teh forms
         */
        initForm:function () {

            var i, actions;

            function submitForm(e) {

                // grab the button that was clicked
                var src = e.srcElement,
                    action;

                // Get the action the user wish to execute
                action = src.dataset['action'];

                // Set the form action
                document.getElementById('action').value = action;

                // submit the form
                document.querySelector('form').submit();
            }

            // Attach the buttons events
            actions = document.querySelectorAll('[data-action]');
            for (i in actions) {
                actions[i].onclick = submitForm;
            }
        },

        ajax:function (url, callback) {

            var xhr = new XMLHttpRequest();
            this.postBody = (arguments[2] || "");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4)
                    callback(xhr.responseText);
            };

            if (this.postBody !== "") {
                xhr.open("POST", url, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('Connection', 'close');
            } else {
                xhr.open("GET", url, true);
            }

            xhr.send(this.postBody);
        }
    }

}();


