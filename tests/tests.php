<?php
// Get the root directory of the project
$path = $_SERVER['DOCUMENT_ROOT'];

// Get the db object
include($path . '/src/common/includes.php');

$DBLayer = DBLayer::getInstance();