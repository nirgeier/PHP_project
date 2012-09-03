<?php

    namespace Moood;
    use PDO;
    use Moood\helpers\Utils;

    /**
     * This class will be used as the DB handler.<br/>
     * Here we will have all the DB related code.<br/>
     *
     * The purpose of the class was simply to learn how to parse config file and to initialize the db connection.
     * The class contain
     *
     * @class DBLayer
     */
    class DBLayer {

        /**
         * Singleton pattern
         */
        private static $instance;

        /**
         * Flag to mark that we have init the DB and its ok.
         * We use it since we redirect to the createDB if needed and since this class is a singleton
         * it will not call the CTOR when we return.
         */
        private static $isValidDB;

        /**
         * Database connection instance
         *
         * @var pdo
         */
        private $pdo = '';

        /**
         * Load the Database queries.
         * All the queries defined in sql file: db/queries.sql
         *
         * @var String host
         */
        private $sql_queries;

        /**
         * Ths configuration file
         */
        private $config;

        /**
         * Constructor
         * Here we will read the connection properties and initialize the connection object
         */
        private function __construct() {

            // static member = use self:: and $this->
            self::$isValidDB = false;

            // Use the global project root. The global defined in the global.src file
            $ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

            // read the db configuration and init the connection settings
            $this->config = parse_ini_file($ROOT_PATH . '/config/config.ini');

            // Load the sql's queries
            $this->sql_queries = parse_ini_file($ROOT_PATH . '/db/queries.sql');

            if (!$this->testConnection()) {
                header('Location: /views/create_db.php');
            } else {
                $username = $this->config['db.username'];
                $password = $this->config['db.password'];
                $hostname = $this->config['db.hostname'];
                $database = $this->config['db.database'];

                // try to connect to database. we expect error if the database does not exists
                $this->pdo = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);

                self::$isValidDB = true;
            }
        }

        /**
         * This method will test if the database connection is valid or not.
         *
         * @return - True/False if the connection values are working or not.
         */
        private function testConnection() {

            // First of all try to connect to the mySQL server.
            $conn = mysql_connect($this->config['db.hostname'], $this->config['db.username'], $this->config['db.password'], '');
            if (!$conn) {
                return false;
            }

            // Check to see if the requested database exist
            if (!mysql_select_db($this->config['db.database'], $conn)) {
                return false;
            }

            return true;
        }

        /**
         * get the instanceof the class
         */
        public static function getInstance() {

            if (!self::$isValidDB || !self::$instance) {
                self::$instance = new DBLayer();
            }

            return self::$instance;
        }

        /**
         * This method will execute sql query.
         *
         * @param queryId - The query id to execute. if no value is given the method will seach for it as request param.
         * @param params -  List of parameters to bind to teh stored procedure.
         *                  If no parameters are passed all the request params will be used as bind parameters.
         *
         * @return - Returns an array containing all of the result set rows
         */
        public function executeQuery($queryId = null, $params = null) {

            if (!isset($queryId)) {
                $queryId = Utils::getParam('queryId', null);
                if (!isset($queryId)) {
                    throw new Exception('Missing queryId');
                }
            }
            // -----------------------------------------------------------------------------------
            // -- If no parameters are passed auto build the params from all the GET/POST pairs --
            // -----------------------------------------------------------------------------------
            if (!isset($params)) {
                $params = array();

                // We read the parameters form the request since it contains both get and post params
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

            // Set the error message
            if ($error[0] > 0) {
                $_REQUEST['DBLayer.executeQuery.error'] = $statment->errorInfo();
            }

            // return all the rows
            return $statment->fetchAll();
        }
    }

