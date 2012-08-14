<?php
session_start();

$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
include_once $ROOT_PATH . '/src/common/includes.php';


DBLayer::getInstance();