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
     * @var int $level The level of the
     */
    private $level = 0;

    /**
     * This function is simply printing message
     * @static
     * @param $message Message to log
     */
    static function log($message) {
        echo $message;
    }

}
