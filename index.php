<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/config/config.php';
require_once APP_PATH . '/core/Router.php';

$router = new Router();
$router->ejecutar();