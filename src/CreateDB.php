<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: nir
     * Date: 7/31/12
     * Time: 8:04 PM
     * To change this template use File | Settings | File Templates.
     */
    class CreateDB {

        // Error message if any
        private $errorMessage = null;

        // CTOR
        public function __construct() {

            // Get the action that we wish to execute
            // We use the isset so we will not see notice messageß
            $action = isset($_POST['action']) ? $_POST['action'] : null;

            if (isset($action)) {
                switch ($action) {
                    case 'test':
                        $this->testConnection();
                        break;
                    case 'create':
                        //echo 'create';
                }
            }
        }

        /**
         * This method will test if the database connection is valid or not.
         */
        public function testConnection() {

            // We did not do any validation, assuming that the input for this method is correct.
            // The purpose her is to connect to the database and not to do input validation
            $connectionStr = 'mysql:';
            $connectionStr .= 'host=' . $_POST['hostname'] . ';';
            $connectionStr .= 'dbname=' . $_POST['database'];

            $pdo = new PDO($connectionStr, $_POST['username'], isset($_POST['password']) ? $_POST['password'] : '');
            $statement = $pdo->query("SELECT * FROM USERS");
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            //echo($row.length);
        }

        public function createDB() {

            return;
            $mysqli = new mysqli($_POST['hostname'],$_POST['username'], isset($_POST['password']) ? $_POST['password'] : '', $_POST['database']);

            /* check connection */
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            $query = "SELECT CURRENT_USER();";
            $query .= "SELECT Name FROM City ORDER BY ID LIMIT 20, 5";

            /* execute multi query */
            if ($mysqli->multi_query($query)) {
                do {
                    /* store first result set */
                    if ($result = $mysqli->store_result()) {
                        while ($row = $result->fetch_row()) {
                            printf("%s\n", $row[0]);
                        }
                        $result->free();
                    }
                    /* print divider */
                    if ($mysqli->more_results()) {
                        printf("-----------------\n");
                    }
                } while ($mysqli->next_result());
            }

            /* close connection */
            $mysqli->close();
        }


    }

