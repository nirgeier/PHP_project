<?php
class Users {

    private $dbLayer;

    // Error message if any
    private $errorMessage = null;

    // CTOR
    public function __construct() {
        $this->dbLayer = DBLayer::getInstance();

        // Get the action that we wish to execute
        // We use the isset so we will not see notice messageß
        $action = isset($_POST['action']) ? $_POST['action'] : null;

        if (isset($action)) {
            switch ($action) {
                case 'register':
                    $this->register();
                    break;
                case 'login':
                    $this->login();
                    break;
                case 'logout':
                    $this->logout();
                    break;
            }
        }
    }

    public function register() {
        // Get the form values
        $params = array(
            ':username' => Utils::getParam('username'),
            ':password' => Utils::getParam('password'),
            ':email' => Utils::getParam('email'),
            ':first_name' => Utils::getParam('first_name'),
            ':last_name' => Utils::getParam('last_name'),
            ':nick_name' => Utils::getParam('nick_name')
        );

        // Get the user details from DB
        $userDetails = $this->dbLayer->executeQuery('users.register', $params);

        if ($userDetails) {
            echo 'Login Ok...';
            $userDetails = $userDetails[0];

            // Get the userId
            $userId = $userDetails['id'];
        } else {
            echo('Login failed');
        }
    }

    public function login() {

        // Get the form values
        $params = array(
            ':username' => Utils::getParam('username'),
            ':password' => Utils::getParam('password')
        );

        // Get the user details from DB
        $userDetails = $this->dbLayer->executeQuery('users.select_user', $params);

        if ($userDetails) {
            $userDetails = $userDetails[0];

            // Get the userId
            $userId = $userDetails['id'];
        } else {
            echo('Login failed');
        }

    }

    public function logout() {
    }
}
