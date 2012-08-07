<?php

/**
 * This class is used as helper class.
 * It will include the common methods that we will need to use
 */
class Utils {


    public static function getGravatar($email) {

        // in order to retrieve the gravatr details we need to hash the email address
        $emailHash = md5(strtolower(trim($email)));
        
        
    }
}

