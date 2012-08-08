<?php

/**
 * This class is used as helper functions.
 * It will include the common methods that we will need to use
 */
Class Utils {

    public static function getParam($name) {
        $value = isset($_POST[$name]) ? $_POST[$name] : /*isset($_GET[$name]) ? $_GET[$name] :*/ '';
        return htmlspecialchars($value);
    }
}
