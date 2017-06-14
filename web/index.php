<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
require_once 'utils/common.func.php';
$content = 'Hello';
echo var_dump($GLOBALS);
showPage($content);
