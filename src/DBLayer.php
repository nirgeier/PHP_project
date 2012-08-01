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
    private $host = '';

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
        $host = $config['db.host'];
        $db_name = $config['db.dbname'];

        // try to connect to database. we expect error if the database does not exists
        try {

            $this->pdo = new PDO('mysql:host=' . $host . ';dbname=' . $db_name . 'f', $username, $password);
            // If we reached this point we have a valid DB connection
            
            // Load the sql's queries
            $this->sql_queries = parse_ini_file($ROOT_PATH . '/db/queries.sql');
            
        } catch (PDOException $e) {
            // This error code 42000 means that we dont have the database yet,
            // We are now going to create it.
            print_r($e->getCode());
            if ($e->getCode() === 1049) {
                echo 'Databse ' . $db_name . ' does not exist. creating new db';
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
     * This method will test if the database connection is valid or not.
     */
    private function test() {
        $statement = $this->pdo->query("SELECT * FROM USERS");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        //echo($row.length);
    }

    /**
     * Create the database and the schema
     */
    private function createDB() {

        /*
           $con = mysql_connect("localhost", "peter", "abc123");
           if (!$con) {
               die('Could not connect: ' . mysql_error());
           }
   
           if (mysql_query("CREATE DATABASE my_db", $con)) {
               echo "Database created";
           } else {
               echo "Error creating database: " . mysql_error();
           }
   
           mysql_close($con);
        */
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
}

