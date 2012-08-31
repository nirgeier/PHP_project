<?php

    namespace Moood\helpers;

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
        public static function getParam($name, $default = null) {
            $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
            return isset($value) ? htmlspecialchars($value) : $default;
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

        /**
         * This function will load xml from url and return it as Json
         *
         * @param $url - The url to load the xml from
         * @return string - The convertion to json from the given XML
         */
        public static function XmlToJson($url) {

            $fileContents = file_get_contents($url);
            $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
            $fileContents = trim(str_replace('"', "'", $fileContents));
            $simpleXml = simplexml_load_string($fileContents);
            $json = json_encode($simpleXml);
            return $json;
        }

    }
