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
         * Constructor
         * Here we will read the connection properties and initialize the connection object
         */
        private function __construct() {

            // check to see if we have valid id
            if (!isset($_REQUEST['validDB'])) {
                $this->initDBConnection();
            }

        }

        /**
         * This method will open the connection to the database.
         * Once the PDO object created we load the sql file and store it locally
         */
        private function initDBConnection() {
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
                    header('Location: /views/create_db.php');
                } else {
                    die("DB ERROR: " . $e->getMessage());
                }
            } catch (Exception $e1) {
                echo 'Databse ' . $database . ' does not exist. creating new db';
                header('Location: /views/create_db.php');
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

