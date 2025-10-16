<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

define('BASE_URL', '/tauheed-academy-project');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tauheed-academy-project');


$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error) {
    die('Connection Failed' . $connection->connect_error);
}
