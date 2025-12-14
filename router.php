<?php

require_once __DIR__ . '/routes/web.php';

function normalize_url($url)
{
    return rtrim(strtolower($url), '/');
}

$fullUrl = normalize_url(
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://' . $_SERVER['HTTP_HOST']
        . strtok($_SERVER['REQUEST_URI'], '?')
);

$routeFound = false;

foreach ($routes as $name => $route) {

    if (!isset($route['url'])) continue;

    if (normalize_url($route['url']) === $fullUrl) {
        $routeFound = true;

        // Convert full URL → local file path
        $path = str_replace($baseUrl, '', $route['url']);

        // ✅ Prevent empty path
        if ($path === '' || $path === '/') {
            $path = '/pages/dashboard.php'; // your home page
        }

        require __DIR__ . $path;
        exit;
    }
}

// ✅ If no route matched → show 404
http_response_code(404);

$path404 = str_replace($baseUrl, '', $routes['404']['url']);
require __DIR__ . $path404;
exit;
