<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Site Configuration - Updated for /med/ folder
define('SITE_NAME', 'C-Care Portal');
define('SITE_URL', 'http://localhost/med/');
define('SITE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/med/');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ors_system');
define('DB_USER', 'root');
define('DB_PASS', '');

// Timezone
date_default_timezone_set('America/New_York');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Functions
require_once SITE_PATH . 'includes/functions.php';
?>