<?php
/**
 * Initializing of framework
 */

// Main constants
define('CORE_PATH', realpath(__DIR__));
define('SITE_PATH', realpath(CORE_PATH.'/../site'));
define('PUBLIC_PATH', realpath(CORE_PATH.'/../../web'));

// Defaults
define('MVC_DEFAULT_ACTION', 'login'); // Default request will be /main/index

// Include libraries and framework parts
require_once CORE_PATH.'/core.func.php';
require_once CORE_PATH.'/common.func.php';
require_once SITE_PATH.'/models/User.php';

// For authorization etc
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);