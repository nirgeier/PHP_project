<?php


    namespace Moood;

    use PDO;

    /**
     * This class will auto create the DB for the application.
     * The idea behind this is that the install process will be transparent to the user.
     **/
    class CreateDB {

        /**
         * Process the create database action
         */
        public function processRequest() {

            // Get the action that we wish to execute
            // We use the isset so we will not see notice messageß
            $action = isset($_POST['action']) ? $_POST['action'] : null;

            if (isset($action)) {
                switch ($action) {
                    case 'create':
                        $this->createDB();
                        break;
                }
            }
        }

        /**
         * This function create the database if needed and executing the dump file if needed
         */
        public function createDB() {

            // Try to connect to the DB.
            // If we got to this point the connection should fail
            // First of all try to connect to the mySQL server.

            // First of all try to connect to the mySQL server.
            $conn = mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password']);
            if (!$conn) {
                $_REQUEST['error'] = 'mySQL is not running or maybe<br/>wrong username / password';
                return;
            }

            // Check to see if the requested database exist
            if (!mysql_select_db($_POST['database'], $conn)) {

                // Create the databse
                if (!mysql_query('CREATE DATABASE ' . $_POST['database'], $conn)) {
                    $_REQUEST['error'] = "Error creating database: " . mysql_error();
                    return;
                }

                mysql_close($conn);


                // From this point i switched driver since this was the only way i was able to
                // execute dump file anf not a single SQL query.
                $conn = new \mysqli($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database']);

                if (mysqli_connect_error()) {
                    $_REQUEST['error']('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
                    return;
                }

                $sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/db/dump.sql');
                if (!$sql) {
                    $_REQUEST['error'] = 'Error opening file: ' . $_SERVER['DOCUMENT_ROOT'] . '/db/dump.sql';
                    return;
                }

                // Execute the dump script
                if (!mysqli_multi_query($conn, $sql)) {
                    $_REQUEST['error'] = 'Error while executing dump file: ' . $_SERVER['DOCUMENT_ROOT'] . '/db/dump.sql';
                    return;
                }

                // Database was successfully created.
                // Redirect to login page.
                $conn->close();

            }

            header('Location: /views/user/login.php');
        }

    }

