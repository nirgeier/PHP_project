<?php

    /**
     * This class will be used as the DB manager.<br/>
     * Here we will have all the DB related code.<br/>
     *
     * The purpose of the class is simply to lear how t parse config file and to initialize the db connection
     *
     * @class DBLayer
     */
    class DBLayer {

        /**
         * Singleton pattern
         */
        private static $instance;

        /**
         * Database connection instance
         *
         * @static
         * @var pdo
         */
        private $pdo = '';

        /**
         * Database user name
         * @var String $username - The database username
         */
        private $username = '';

        /**
         * Database password
         *
         * @var String password
         */
        private $password = '';

        /**
         * Database host (ip/url)
         *
         * @var String host
         */
        private $hostname = '';

        /**
         * Load the Database queries
         *
         * @var String host
         */
        private $sql_queries;

        /**
         * Database/Schema name
         * @var String $db_name
         */
        private $db_name = '';

        /**
         * Constructor
         * Here we will read the connection properties and initialize the connection object
         */
        private function __construct() {

            // check to see if we have valid id
            if (!isset($_REQUEST['validDB'])) {
                $this->initDB();
            }

        }


        private function initDB() {
            // Use the global project root. The global defined in the global.src file
            $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

            // read the db configuration and init the connection settings
            $config = parse_ini_file($ROOT_PATH . '/config/config.ini');

            $username = $config['db.username'];
            $password = $config['db.password'];
            $hostname = $config['db.hostname'];
            $database = $config['db.database'];

            // try to connect to database. we expect error if the database does not exists
            try {
                $this->pdo = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
                // If we reached this point we have a valid DB connection

                // Load the sql's queries
                $this->sql_queries = parse_ini_file($ROOT_PATH . '/db/queries.sql');

                // Set the session flag that the db is accessible.
                $_SESSION['validDB'] = true;

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                // This error code 42000 means that we dont have the database yet,
                // We are now going to create it.

                if ($e->getCode() === 1049) {
                    echo 'Databse ' . $database . ' does not exist. creating new db';
                    header('Location: /pages/create_db.php');
                } else {
                    die("DB ERROR: " . $e->getMessage());
                }
            } catch (Exception $e1) {
                echo 'Databse ' . $database . ' does not exist. creating new db';
                header('Location: /pages/create_db.php');
            }
            if (!$this->pdo) {
                die('Could not connect to database');
            }
        }

        /**
         * get the instanceof the class
         */
        public static function getInstance() {

            if (!self::$instance) {
                self::$instance = new DBLayer();
            }

            return self::$instance;
        }


        /**
         * This method will execute sql query
         * @return string
         */
        public function executeQuery($queryId = null, $params = null) {

            if (!isset($queryId)) {
                $queryId = $_REQUEST['queryId'];
            }
            // -----------------------------------------------------------------------------------
            // -- If no parameters are passed auto build the params from all the GET/POST pairs --
            // -----------------------------------------------------------------------------------
            if (!isset($params)) {
                $params = array();
                foreach ($_REQUEST as $key => $value) {
                    $params[':' . $key] = $value;
                }

            }

            // Get the query we wish to execute
            $query = $this->sql_queries[$queryId];
            $statment = $this->pdo->prepare($query);
            $statment->setFetchMode(PDO::FETCH_ASSOC);
            $statment->execute($params);

            // Check to see if we have error or not
            $error = $statment->errorInfo();
            if ($error[0] > 0) {
                $_REQUEST['DBLayer.executeQuery.error'] = $statment->errorInfo();
            }
            return $statment->fetchAll();
        }


        public function getUsername() {
            return $this->username;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getHost() {
            return $this->host;
        }

        public function getDbname() {
            return $this->db_name;
        }

        public function getSqlQuery($queryId) {
            return $this->sql_queries[$queryId];
        }

        public function __sleep() {
            return array();
        }

        public function __wakeup() {

        }


    }
