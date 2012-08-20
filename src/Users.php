<?php
    class Users {

        private $dbLayer;

        // CTOR
        public function __construct() {
            $this->dbLayer = DBLayer::getInstance();

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

            if (isset($action)) {
                switch ($action) {
                    case 'username':
                        $this->checkField('username', 'users.check_username', 'The username you requested is already registered');
                        break;
                    case 'email':
                        $this->checkField('email', 'users.check_email', 'This email is already registered');
                        break;
                    case 'register':
                        $this->register();
                        break;
                    case 'update':
                        $this->update();
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

            // Place holder for the registration error
            $_REQUEST['registerError'] = null;

            // Get the form values
            $params = array(
                ':username' => Utils::getParam('username'),
                ':password' => sha1(Utils::getParam('password')),
                ':email' => Utils::getParam('email'),
                ':first_name' => Utils::getParam('first_name'),
                ':last_name' => Utils::getParam('last_name'),
                ':nick_name' => Utils::getParam('nick_name'),
                ':image' => Utils::getParam('image')
            );

            // Get the user details from DB
            $this->dbLayer->executeQuery('users.register', $params);

            if ($_REQUEST['DBLayer.executeQuery.error'] !== null) {
                $_REQUEST['registerError'] .= $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                // registration was OK, auto login the user
                $this->login();
            }
        }

        public function update() {

            // Place holder for the registration error
            $_REQUEST['updateError'] = null;

            // Get the form values
            $params = array(
                ':id' => Utils::getParam('id'),
                ':password' => sha1(Utils::getParam('password')),
                ':email' => Utils::getParam('email'),
                ':first_name' => Utils::getParam('first_name'),
                ':last_name' => Utils::getParam('last_name'),
                ':nick_name' => Utils::getParam('nick_name'),
                ':image' => Utils::getParam('image')
            );

            // !!!Important -
            // This is a security check to see that the user we try to update (user_id_ is the current logged in user
            // and not some else who is trying to send different userId in the request
            if (Utils::getParam('id') != $_SESSION['userId']) {
                $_REQUEST['updateError'] .= 'Project output only: Got you. You are trying to update different user :-)';
                return;
            }

            // Get the user details from DB
            $this->dbLayer->executeQuery('users.update', $params);

            if (isset($_REQUEST['DBLayer.executeQuery.error'])) {
                $_REQUEST['updateError'] .= $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                $_REQUEST['updateError'] = 'Details updated successfully.';
            }

            // Load the updated user details
            $userDetails = $this->dbLayer->executeQuery('users.select_user_by_id', array(':id' => $_SESSION['userId']));

            if ($userDetails) {
                //var_dump($userDetails);
                $userDetails = $userDetails[0];

                // Set the user details
                $_SESSION['user'] = $userDetails;
            }
        }

        public function login() {

            // Get the form values
            $params = array(
                ':username' => Utils::getParam('username'),
                ':password' => sha1(Utils::getParam('password'))
            );

            // Get the user details from DB
            $userDetails = $this->dbLayer->executeQuery('users.select_user', $params);

            if ($userDetails) {
                $userDetails = $userDetails[0];

                // Get the userId
                $userId = $userDetails['id'];
                $_SESSION['userId'] = $userId;

                // Set the user details
                $_SESSION['user'] = $userDetails;

                // We found the user login valid - redirect to the application page.
                header("Location: /pages/playlists.php");

            } else {
                $_REQUEST['loginError'] = 'Wrong user name/password. Please try again';
            }

        }

        public function checkField($filedName, $sqlId, $errorMessage) {
            // Get the form values
            $params = array(
                ':' . $filedName => Utils::getParam($filedName),
            );

            $data = $this->dbLayer->executeQuery($sqlId, $params);
            if ($data[0]['count'] !== "0") {
                echo '{"error": "' . $errorMessage . '"}';
            } else {
                echo '{"status": "ok" }';
            }
        }

        public function logout() {
        }
    }
