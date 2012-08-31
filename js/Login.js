!(function () {

    Moood.initForm();

    var valid,
        username = document.querySelector('#username'),
        password = document.querySelector('#password'),
        loginButton = document.querySelector('#loginButton'),
        tooltip = document.querySelector('.tooltip');

    function validate() {
        valid = true;

        // Check the username field
        valid &= username.value && username.value.length > 3;
        valid &= password.value && password.value.length > 6;

        // Set the disabled class
        loginButton.classList[valid ? 'remove' : 'add']('disabled');
        tooltip.classList[valid ? 'add' : 'remove']('hidden');
    }

    username.addEventListener('keydown', validate, false);
    password.addEventListener('keydown', validate, false);

})();
