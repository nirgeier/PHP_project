<?php

    namespace Moood\User;
    use Moood\DBLayer;

    /**
     * This class will store all the user information.
     * The user details, songs and playlist
     * It might not be a good performance idea but for the project i decided to store all the user data in memory since
     * it contains a small amount of data and its good practice to manage it.
     *
     */
    class User {

        // The userId
        private $userId;

        // The user details information (Table users)
        private $userData;

        // List of users playlist
        private $playlist;

        // CTOR
        public function __construct($userId) {

            // Set the userId. Will be used later on to load all data from database
            $this->userId = $userId;

            // Load the user data
            $this->loadUser();

            // Load user playlist
            $this->loadPlaylist();

            return $this;
        }

        /**
         * Load the user details from database
         */
        private function loadUser() {
            $dbLayer = DBLayer::getInstance();

            $this->userData = null;

            // Load the user details
            $data = $dbLayer->executeQuery('users.select_user_by_id', array(':user_id' => $this->userId));

            if ($data) {
                $this->userData = $data[0];
            }
        }

        private function loadPlaylist() {
            $dbLayer = DBLayer::getInstance();

            $this->playlist = null;

            // load the user playlist
            $data = $dbLayer->executeQuery('users.playlist', array(':user_id' => $this->userId));

            if ($data) {
                // Clear prevoius data - if any
                $items = array();

                // Get all the playlist records
                foreach ($data as $item) {
                    array_push($items, $item);
                }

                $this->playlist = $items;
            }

        }

        public function reload() {
            $this->loadUser();
            $this->loadPlaylist();
        }

        public function getPlaylist() {
            return $this->playlist;
        }

        public function getUserData() {
            return $this->userData;
        }

    }
