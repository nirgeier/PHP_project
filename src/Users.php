<?php
    /**
     * @author  Nir Geier
     * Created: 03/08/12 18:49
     *
     *
     */
    class Users {

        private $dbLayer;

        // Error message if any
        private $errorMessage = null;

        // CTOR
        public function __construct() {
            echo('kkkkk');
            $this->dbLayer = DBLayer::getInstance();

            echo($this->dbLayer . executeQuer());

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
            echo DBLayer::getInstance();

        }

        public function login() {
        }

        public function logout() {
        }
    }
