<?php
    /**
     * This class is a basic logger implementation.
     * Since we wanted to practice in writing PHP we did not used logging framework
     *
     *
     */
    class Logger {

        /**
         * @var $name The name of the logger
         */
        private $name = '';

        /**
         * The logger levels
         */
        private $LEVELS = array(
            0 => 'DEBUG',
            1 => 'INFO',
            2 => 'WARN',
            3 => 'ERROR'
        );

        /**
         * @var int $level The level of the
         */
        private $level = 0;

        public function debug($message) {

        }

        /**
         * This function is simply printing message
         * @static
         * @param $message Message to log
         */
        private function log($message) {
            echo $message;
        }

    }
