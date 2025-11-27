<?php
// Simple .env loader for pure PHP
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Save into environment
            $_ENV[$key] = $value;
            putenv("$key=$value"); // optional, if you want getenv() support
        }
    }
}

// Load .env file from project root
loadEnv(__DIR__ . '/../.env');
