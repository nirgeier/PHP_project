<?php

    namespace Moood\User;
    use Moood\helpers\Utils;
    use Moood\DBLayer;

    class Playlist {

        /**
         * Execute the action.
         * The action is extracted from the request
         */
        public function processRequest() {

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

            if (isset($action)) {
                switch ($action) {
                    case 'search':
                        $this->searchYouTube();
                        break;
                    case 'add':
                        $this->addPlaylist();
                        break;
                    case 'delete':
                        $this->deletePlaylist();
                        break;
                    case 'addSong':
                        $this->addSong();
                        break;
                    case 'songs_list':
                        $this->loadSongs();
                        break;
                }
            }
        }

        /**
         * This method will fetch the playlist form YouTube.
         * Once we get the playlist we will parse and process the results.
         *
         * The function sets a REQUEST value names 'song' with an array of the results.
         */
        private function searchYouTube() {

            // Get the params we need
            $searchTerm = urlencode(Utils::getParam('query', 'ניר גייר'));
            $numberOfRecords = Utils::getParam('numberOfSongs', 10);

            // Get the playlist data from you tube
            $url = 'http://gdata.youtube.com/feeds/api/videos?alt=json&max-results=' . $numberOfRecords . '&format=5&q=' . $searchTerm;

            // Get the playlist data
            $json = file_get_contents($url);

            // Convert the JSON to PHP array
            $data = json_decode($json, true);

            // Get the Array of the playlist items
            $items = $data['feed']['entry'];

            // The playlist array with the videos
            $songs = array();

            // Loop over the playlist entries that we wish to display
            foreach ($items as $item) {
                // Extract the data we want
                $title = $item['title']['$t'];
                $content = $item['content']['$t'];
                $videoId = substr($item['id']['$t'], strripos($item['id']['$t'], '/') + 1);

                // Get the video URL
                foreach ($item['link'] as $link) {
                    if ($link['rel'] === 'alternate') {
                        $videoURL = $link['href'];
                        break;
                    }
                }

                array_push($songs, array(
                    'title' => $title,
                    'content' => $content,
                    'href' => $videoURL,
                    'videoId' => $videoId,
                ));

            }

            // Set the songs in the request
            $_REQUEST['songs'] = $songs;

        }

        /**
         * This function will add new playlist to the database
         * Once the playlist was added we relaod the user playlist so it will be displayed on the page instantly.
         *
         */
        public function addPlaylist() {

            $dbLayer = DBLayer::getInstance();

            $dbLayer->executeQuery('playlist.add', array(
                ':user_id' => $_SESSION['userId'],
                ':name' => Utils::getParam("name")
            ));

            $user = $_SESSION['user'];
            $user->reload();
        }

        /**
         * This function will delete playlist form the database.
         * Deleting a playlist require to delete records from several tables in a specific order
         * since there are FOREIGN_KEYS in the database. Due to that the delete is done using SQL PROCEDURE
         * which can found in the dump.sql file.
         */
        public function deletePlaylist() {

            $dbLayer = DBLayer::getInstance();

            $dbLayer->executeQuery('playlist.delete', array(
                ':user_id' => $_SESSION['userId'],
                ':p_id' => Utils::getParam("pId")
            ));

            $user = $_SESSION['user'];
            $user->reload();
        }

        /**
         * Adds a new song to the playlist
         */
        public function addSong() {

            $dbLayer = DBLayer::getInstance();

            $dbLayer->executeQuery('playlist.add.song', array(
                ':videoId' => Utils::getParam("id"),
                ':pId' => Utils::getParam("pId"),
                ':title' => Utils::getParam("title"),
            ));
        }

        /**
         * Load songs of the given playlist.
         * The playlist id is extracted from the request and the data is store as REQUEST['songs']
         */
        public function loadSongs() {
            $dbLayer = DBLayer::getInstance();

            $data = $dbLayer->executeQuery('playlist.songs', array(
                ':pId' => Utils::getParam("pId")
            ));

            if ($data) {
                $_REQUEST['songs'] = $data;
            }
        }

    }


