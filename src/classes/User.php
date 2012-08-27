<?php

    /**
     * This class will store all the user information.
     * The user details, songs and playlist
     * It might not be a good performance idea but for the project i decided to store all the user data in memory since
     * it contains a small amount of data and its good practice to manage it.
     *
     */
    class User {

        // Database object reference
        private $dbLayer;

        // The userId
        private $userId;

        // The user details information (Table users)
        private $userData;

        // List of users playlists
        private $playlists;

        // CTOR
        public function __construct($userId) {

            // Set the userId. Will be used later on to load all data from database
            $this->userId = $userId;

            $this->dbLayer = DBLayer::getInstance();

            // Load the user data
            $this->loadUser();

            // Load user playlists
            $this->loadPlaylists();

            return $this;
        }

        /**
         * Load the user details from database
         */
        private function loadUser() {
            // Load the user details
            $data = $this->dbLayer->executeQuery('users.select_user_by_id', array(':id' => $this->userId));

            if ($data) {
                $this->userData = $data[0];
            }
        }

        private function loadPlaylists() {
            // load the user playlists
            $data = $this->dbLayer->executeQuery('users.playlists', array(':id' => $this->userId));

            if ($data) {
                // Clear prevoius data - if any
                $items = array();

                // Get all the playlists records
                foreach ($data as $item) {
                    array_push($items, $item);
                }
            }

            $this->playlists = $items;
        }

        public function getPlaylists() {
            return $this->playlists;
        }

        public function getUserData() {
            return $this->userData;
        }

    }
