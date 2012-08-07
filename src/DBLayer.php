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

            // Use the global project root. The global defined in the global.src file
            global $ROOT_PATH;

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

            } catch (PDOException $e) {
                // This error code 42000 means that we dont have the database yet,
                // We are now going to create it.

                if ($e->getCode() === 1049) {
                    echo 'Databse ' . $database . ' does not exist. creating new db';
                    header('Location: /pages/create_db.php');
                } else {
                    die("DB ERROR: " . $e->getMessage());
                }
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
        public function executeQuery($queryId, $params = null) {
            // Get the query we wish to execute
            $query = $this->sql_queries[$queryId];
            return $query;
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
    }

