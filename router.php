<?php

require_once __DIR__ . '/routes/web.php';

function normalize_url($url)
{
    return rtrim(strtolower($url), '/');
}

function throw403($routes, $baseUrl)
{
    http_response_code(403);
    require __DIR__ . str_replace($baseUrl, '', $routes['403']['url']);
    exit;
}

function throw404($routes, $baseUrl)
{
    http_response_code(404);
    require __DIR__ . str_replace($baseUrl, '', $routes['404']['url']);
    exit;
}

$fullUrl = normalize_url(
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://' . $_SERVER['HTTP_HOST']
        . strtok($_SERVER['REQUEST_URI'], '?')
);

// ✅ Block direct access to PHP files inside /pages/
if (preg_match('#/pages/.*\.php$#i', $_SERVER['REQUEST_URI'])) {
    throw404($routes, $baseUrl);
}

// ✅ Block extra path segments after a PHP file
if (preg_match('#\.php/.+#', $_SERVER['REQUEST_URI'])) {
    throw404($routes, $baseUrl);
}

// ✅ Block malformed PHP file names (index.phpXYZ)
if (preg_match('#\.php[^/?]#', $_SERVER['REQUEST_URI'])) {
    throw404($routes, $baseUrl);
}

foreach ($routes as $name => $route) {

    if (!isset($route['url'])) continue;

    if (normalize_url($route['url']) === $fullUrl) {

        // Convert full URL → local file path
        $path = str_replace($baseUrl, '', $route['url']);

        // ✅ Default home page
        if ($path === '' || $path === '/') {
            $path = '/pages/index.php';
        }

        $fullPath = __DIR__ . $path;
        // ✅ If it's a directory, try to load its index.php
        if (is_dir($fullPath)) {
            $indexFile = rtrim($fullPath, '/') . '/index.php';

            if (file_exists($indexFile)) {
                require $indexFile;
                exit;
            }

            // ❌ Directory has no index → forbidden
            throw403($routes, $baseUrl);
        }


        // ✅ File missing → 404
        if (!file_exists($fullPath)) {
            throw404($routes, $baseUrl);
        }

        // ✅ Load the page
        require $fullPath;
        exit;
    }
}

// ✅ No route matched → 404
throw404($routes, $baseUrl);
