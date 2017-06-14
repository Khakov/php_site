<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once ROOT.'/models/User.php';
session_start();
