<?php

    namespace Moood;

    use Moood\DBLayer;
    use Moood\helpers\Utils;
    use Moood\User\User;

    /**
     * @author  Nir Geier
     *
     * This class will be used as teh back-office class for managing the Database records.
     * We assume that the Database connection is valid and all the tables exist.
     *
     * As for now it contains a limited set of action.
     * We created this class in order to have some kind of backoffice support.
     *
     */
    class Backoffice {

        // CTOR
        public function __construct() {

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

            // Execute the desired action
            if (isset($action)) {
                switch ($action) {
                    case 'login':
                        $this->login();
                        break;
                    case 'users':
                        $this->getData('backoffice.users');
                        break;
                }
            }
        }

        /**
         * Try to login admin user.
         */
        public function login() {

            $dbLayer = DBLayer::getInstance();

            // Get the form values
            $params = array(
                ':username' => Utils::getParam('username'),
                ':password' => sha1(Utils::getParam('password'))
            );

            // Get the user details from DB
            $userDetails = $dbLayer->executeQuery('backoffice.login', $params);

            // Verify that we found user
            if ($userDetails) {
                $userDetails = $userDetails[0];

                // Get the userId
                $userId = $userDetails['id'];
                $_SESSION['userId'] = $userId;

                // Set the user details
                $_SESSION['user'] = new User($userId);

                // We found the user login valid - redirect to the application page.
                header("Location: /views/backoffice/table_template.php?table_name=Users&queryId=backoffice.users");
            }
        }

        /**
         * This method is a general method for getting DB data.
         * We use it to execute SQL Query and to set error message if there was an error.
         *
         * @param $queryId - The query id to execute
         * @param null $params - List of params to bind to the prepare statment.
         *
         * More details can be found in the DBLayer class since this method is a wrapper for $dbLayer->executeQuery
         *
         * @link DBLayer
         */
        public function getData($queryId, $params = null) {
            $dbLayer = DBLayer::getInstance();
            $data = $dbLayer->executeQuery($queryId, $params);

            if (isset($_REQUEST['DBLayer.executeQuery.error'])) {
                $_REQUEST['backoffice.error'] = $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                $_REQUEST['backoffice.data'] = $data;
            }
        }

    }
