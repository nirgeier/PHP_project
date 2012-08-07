<?php
    class Users {

        private $dbLayer;

        // Error message if any
        private $errorMessage = null;

        // CTOR
        public function __construct() {
            $this->dbLayer = DBLayer::getInstance();

            //echo($this->dbLayer->executeQuery("users.select_user", null));

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
            // register users ...
        }

        public function login() {
        }

        public function logout() {
        }
    }
