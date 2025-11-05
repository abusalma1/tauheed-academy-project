
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['submitted'])) {
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== $_SERVER['PHP_SELF']) {
        $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
    } else {
        $_SESSION['previous_page'] = route('home');
    }
}


// echo('Working');

define('BASE_URL', '/tauheed-academy-project');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tauheed_academy_database');


$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error) {
    die('Connection Failed' . $connection->connect_error);
}
