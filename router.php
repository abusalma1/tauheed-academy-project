<?php
include __DIR__ . "/includes/header.php";

// Get the requested path
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Remove project folder name on localhost
$path = str_replace("tauheed-academy-project/", "", $path);

// Default route
if ($path === "") {
    $path = "home";
}

// Check if route exists
if (isset($routes[$path])) {

    // Convert URL → file path
    $file = str_replace($baseUrl, "", $routes[$path]['url']);
    $file = __DIR__ . $file;

    if (file_exists($file)) {
        include $file;
        exit;
    }
}

// If route does NOT exist → 404
include __DIR__ . "/404.php";
exit;
