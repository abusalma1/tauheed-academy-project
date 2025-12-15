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

// Default home page
if ($path === '' || $path === '/') {
$path = '/pages/dashboard.php';
}

$fullPath = __DIR__ . $path;

// ✅ Check if file exists
if (!file_exists($fullPath)) {
http_response_code(404);
require __DIR__ . str_replace($baseUrl, '', $routes['404']['url']);
exit;
}

require $fullPath;
exit;
}
}

// ✅ No route matched → show 404
http_response_code(404);
require __DIR__ . str_replace($baseUrl, '', $routes['404']['url']);
exit;