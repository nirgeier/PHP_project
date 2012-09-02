<?php

    namespace Moood\User;

    use Moood\DBLayer;
    use Moood\helpers\Utils;
    use Moood\User\User;

    /**
     * This class will handle the different user actions.
     * We create instance of this class every time we have actions to execute and in the CTOR
     * we process the requested action
     */
    class UserActions {

        /**
         * This method will process the request and will execute the desired action.
         * The function read the action from the request.
         */
        public function processRequest() {

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

            if (isset($action)) {
                switch ($action) {
                    // Check to see if the username is unique or not.(If its not registred yet)
                    case 'username':
                        $this->checkUniqueValue('username', 'users.check_username', 'The username you requested is already registered');
                        break;
                    // Check to see if the email is unique or not.(If its not registred yet)
                    case 'email':
                        $this->checkUniqueValue('email', 'users.check_email', 'This email is already registered');
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

        /**
         * Register new user.
         * This method extract all the required data from the request and register user.
         *
         * In real application we would have added some validations like: match passwords, valid email address etc.
         * We would have send Emil with verification link of a simple welcome mail.
         *
         * For the scope of the project we simply register new user.
         */
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
            DBLayer::getInstance()->executeQuery('users.register', $params);

            // Check to see if there were any errors
            if ($_REQUEST['DBLayer.executeQuery.error'] !== null) {
                $_REQUEST['registerError'] .= $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                // registration was OK, auto login the user
                $this->login();
            }
        }

        /**
         * Update user details.
         */
        public function update() {

            // Place holder for the registration error
            $_REQUEST['error'] = null;

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
            echo(Utils::getParam('id') .','. $_SESSION['userId']);
            if (Utils::getParam('id') != $_SESSION['userId']) {
                $_REQUEST['error'] .= 'Project output only: Got you. You are trying to update different user :-)';
                return;
            }

            // Get the user details from DB
            DBLayer::getInstance()->executeQuery('users.update', $params);

            if (isset($_REQUEST['DBLayer.executeQuery.error'])) {
                $_REQUEST['error'] .= $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                $_REQUEST['error'] = 'Details updated successfully.';
            }

            // Load the updated user details
            $userData = DBLayer::getInstance()->executeQuery('users.select_user_by_id', array(':id' => $_SESSION['userId']));

            if ($userData) {
                // Set the user details
                $_SESSION['user'] = new User($userData['id']);
            }
        }

        /**
         * @param $filedName - The request param that we want to check. We extract the value from the request
         * @param $sqlId - The sql query id for checking if the given value is unique or not
         * @param $errorMessage - Error message in case the value is not unique
         *
         * @return string - JSON reply with status:ok or error:errorMessage.
         */
        public function checkUniqueValue($filedName, $sqlId, $errorMessage) {
            // Get the form values
            $params = array(
                ':' . $filedName => Utils::getParam($filedName),
            );

            $data = DBLayer::getInstance()->executeQuery($sqlId, $params);
            if ($data[0]['count'] !== "0") {
                echo '{"error": "' . $errorMessage . '"}';
            } else {
                echo '{"status": "ok" }';
            }
        }

        /**
         * This method check to see that the given credentials are valid.
         * Once user is logged in we will load his data
         */
        public function login() {

            // Get the form values
            // The password is encrypted using sha1.
            // We could have used some stronger method like adding a prefix and then encode it and verify it
            // but since this a demo project this is not a issue here in my opnion
            $params = array(
                ':username' => Utils::getParam('username'),
                ':password' => sha1(Utils::getParam('password'))
            );

            // Load the user details
            $data = DBLayer::getInstance()->executeQuery('users.select_user', $params);

            // Check to see if we have a valid user or not
            if ($data) {
                $userData = $data[0];

                // Get the userId
                $_SESSION['userId'] = $userData['id'];

                // Set the user details
                $_SESSION['user'] = new User($userData['id']);

                // Make sure all session content is flushed before redirected
                session_write_close();

                // We found the user login valid - redirect to the application page.
                header("Location: /views/playlist/playlist.php");

                exit();
            } else {
                $_REQUEST['error'] = 'Wrong user name/password. Please try again';
            }

        }

        /**
         * Logout the current user
         */
        public function logout() {

            // Clear the previous user info - if any
            $_SESSION['userId'] = null;
            $_SESSION['user'] = null;

        }
    }
