<?php

session_start();


//Templates and main view paths
define('TEMPLATE_VIEW_PATH', './views/templates/');
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');

// Edit with your database host, name and credentials

define('DB_HOST', 'host');
define('DB_NAME', 'dbname');
define('DB_USER', 'user');
define('DB_PASS', 'password');