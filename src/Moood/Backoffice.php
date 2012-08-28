<?php

    namespace Moood;
    /**
     * @author  Nir Geier
     *
     * This class will be used as teh back-office class for managing the Database records.
     * We assume that the Database connection is valid and all the tables exist.
     *
     *
     */
    class Backoffice {

        private $dbLayer;

        // CTOR
        public function __construct() {

            if (!isset($_SESSION)) {
                session_start();
            }

            $this->dbLayer = Moood_DBLayer::getInstance();

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

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

        public function login() {

            // Get the form values
            $params = array(
                ':username' => Utils::getParam('username'),
                ':password' => sha1(Utils::getParam('password'))
            );

            // Get the user details from DB
            $userDetails = $this->dbLayer->executeQuery('backoffice.login', $params);

            if ($userDetails) {
                $userDetails = $userDetails[0];

                // Get the userId
                $userId = $userDetails['id'];
                $_SESSION['userId'] = $userId;

                // Set the user details
                $_SESSION['user'] = $userDetails;

                // We found the user login valid - redirect to the application page.
                header("Location: /pages/backoffice/table_template.php?table_name=Users&queryId=backoffice.users");
            }
        }

        public function getData($queryId, $params = null) {
            $data = $this->dbLayer->executeQuery($queryId, $params);

            if (isset($_REQUEST['DBLayer.executeQuery.error'])) {
                $_REQUEST['backoffice.error'] = $_REQUEST['DBLayer.executeQuery.error'][2];
            } else {
                $_REQUEST['backoffice.data'] = $data;
            }
        }

    }
