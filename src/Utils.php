<?php

    /**
     * This class is used as helper functions.
     * It will include the common methods that we will need to use
     */
    Class Utils {

        /**
         * Function that try to read parameters form POST/GET and return their value safely.
         *
         * @param $name - The name of teh param
         * @return null|string - The value of the param or null if not found
         */
        public static function getParam($name) {
            $value = isset($_POST[$name]) ? $_POST[$name] : null;
            if (!isset($value)) {
                $value = isset($_GET[$name]) ? $_GET[$name] : null;

            }
            return isset($value) ? htmlspecialchars($value) : null;
        }

        /**
         * This function is used to generate the table headers (TH names).
         * The function convert the db convention 'foo_bar' to 'Foo Bar'.
         *
         * @param $string - The string that we want to convert from 'foo_bar' to 'Foo Bar'
         * @return String - The converted string
         */
        public static function getTableHeader($string) {

            $str = str_replace(' ', ' ', ucwords(str_replace('_', ' ', $string)));
            $str[0] = strtoupper($str[0]);
            return $str;
        }

    }
