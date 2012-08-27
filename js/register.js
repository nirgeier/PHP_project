(function () {

    var valid,
        timer,
        email = document.querySelector('#email'),
        img = document.querySelector('#profile_image'),
        username = document.querySelector('#username'),
        password = document.querySelector('#password'),
        password2 = document.querySelector('#password2'),
        actionButton = document.querySelector('#actionButton'),
        tooltip = document.querySelector('.tooltip');

    Moood.initForm();

    // This is a specific function for this page.
    // It will grab teh user details form Gravatar if the email is registered there.
    $('gravatar').onchange = (function (e) {
        var checkbox = e.srcElement;

        if (checkbox.checked) {

            $$('.ajaxLoader').classList.remove('hidden');

            Moood.ajax('/src/helpers/fetch_gravatar.php?email=' + email.value,
                function (info) {

                    var details;
                    $$('.ajaxLoader').classList.add('hidden');

                    if (info) {
                        details = JSON.parse(info).entry[0];
                        username.value = details.displayName || '';
                        img.value = details.thumbnailUrl || '';
                        $('nick_name').value = (details.preferredUsername || '');
                        $('img').src = (details.thumbnailUrl || '');
                        checkUserName();
                        checkbox.checked = false;

                    }
                });
        }
    });

    function validateForm() {
        valid = true;
        // Check the username field
        valid &= username.value && username.value.length >= 3;
        valid &= password.value && password.value.length >= 5;
        valid &= password.value == password2.value;

        // Set the disabled class
        actionButton.classList[valid ? 'remove' : 'add']('disabled');
        if (tooltip) {
            tooltip.classList[valid ? 'add' : 'remove']('hidden');
        }
    }

    function setUserNameTimer() {
        // Set timer on the keyup so we will not send requests while user is typing
        timer = setTimeout(checkUserName, 1000);
        $('username_error').classList.add('hidden');
        $('username').classList.remove('input_error');
        $('username_status').classList.add('hidden');

    }

    function checkUserName() {
        clearTimeout(timer);

        Moood.ajax('/src/helpers/check_user.php?action=username&username=' + username.value,
            function (reply) {
                var data = reply && JSON.parse(reply);

                if (data && data.error) {
                    username.classList.add('input_error');
                    $('username_error').innerHTML = data.error;
                    $('username_error').classList.remove('hidden');
                    $('username_status').src = '../images/not_ok.png';
                    $('username_status').classList.remove('hidden');
                } else {
                    $('username_status').src = '../images/ok.png';
                    $('username_status').classList.remove('hidden');
                }
            });
    }

    function setEmailTimer() {
        // Set timer on the keyup so we will not send requests while user is typing
        timer = setTimeout(checkEmail, 1000);
        email.classList.remove('input_error');
        $('email_error').classList.add('hidden');
        $('email_status').classList.add('hidden');
    }


    function checkEmail() {
        clearTimeout(timer);

        Moood.ajax('/src/helpers/check_user.php?action=email&email=' + email.value,
            function (reply) {
                var data = reply && JSON.parse(reply);

                if (data && data.error) {
                    email.classList.add('input_error');
                    $('email_error').innerHTML = data.error;
                    $('email_error').classList.remove('hidden');
                    $('email_status').src = '../images/not_ok.png';
                    $('email_status').classList.remove('hidden');

                } else {
                    $('email_status').src = '../images/ok.png';
                    $('email_status').classList.remove('hidden');
                }

            });
    }

    function validatePassword() {

        $('password_error').classList.add('hidden');
        $('password2_error').classList.add('hidden');

        password.classList.remove('input_error');
        password2.classList.remove('input_error');

    }

    function validatePassword2() {
        console.log('validatePassword2: ', password.value, password2.value);
        if (password.value !== password2.value) {
            $('password2_error').innerHTML = 'Passwords does not match';
            $('password2_error').classList.remove('hidden');
            $('password2').classList.add('input_error');
        } else {
            $('password_error').classList.add('hidden');
            $('password2_error').classList.add('hidden');

            $('password').classList.remove('input_error');
            $('password2').classList.remove('input_error');

        }

    }

    username.addEventListener('keyup', setUserNameTimer, false);
    password.addEventListener('keyup', validatePassword, false);
    password2.addEventListener('keyup', validatePassword2, false);
    email.addEventListener('keyup', setEmailTimer, false);

    document.addEventListener('keyup', validateForm, false);

})();