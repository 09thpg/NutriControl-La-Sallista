<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'NutriControl La Sallista');
define('APP_VERSION', '1.0.0');

define('BASE_URL', 'http://localhost/NutriControl-La-Sallista/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'adminrefrigerios');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('MODEL_PATH', APP_PATH . '/models');
define('VIEW_PATH', APP_PATH . '/views');
define('HELPER_PATH', APP_PATH . '/helpers');
define('MIDDLEWARE_PATH', APP_PATH . '/middleware');
define('PUBLIC_PATH', ROOT_PATH . '/public');