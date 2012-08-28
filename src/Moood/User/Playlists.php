<?php

    namespace Moood\User;
    use Moood\helpers\Utils;
    use Moood\DBLayer;

    class Playlists {

        private $dbLayer;

        // CTOR
        public function __construct() {
            $this->dbLayer = DBLayer::getInstance();

            // Get the action that we wish to execute
            // We use the isset so we will not see notice message
            $action = Utils::getParam('action');

            if (isset($action)) {
                switch ($action) {
                    case 'search':
                        $this->searchYouTube();
                        break;
                    case 'load':
                        $this->loadUserPlaylists();
                        break;
                }
            }
        }

        /**
         * This method will fetch the playlist form you tube.
         * Once we get the playlist we will parse and process the results
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
                    'videoId' => $videoId
                ));

            }

            // Set the songs in the request
            $_REQUEST['songs'] = $songs;

        }

        public function loadUserPlaylists() {
        }
    }


