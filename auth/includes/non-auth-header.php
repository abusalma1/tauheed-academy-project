<?php
include(__DIR__ . '/../../routes/functions.php');

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Extract allowed paths from your routes
$allowedPaths = array_map(function ($r) {
  return parse_url($r['url'], PHP_URL_PATH);
}, $routes);

// If the current URL path is NOT allowed → 404
if (!in_array($requestPath, $allowedPaths)) {
  header("Location: " . $routes['404']['url']);
  exit();
}

//  Redirect if already logged in
if (isset($_SESSION['user_session'])) {
  $_SESSION['failure'] = "Access Denied!";
  header('Location: ' . route('home'));
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?> - Tauheed Academy</title>
  <link href="<?= asset('css/tailwind.css') ?>" rel="stylesheet">
  <link href="<?= asset('css/fontawesome.css') ?>" rel="stylesheet">
  <link href="<?= asset('css/tom-select.css') ?>" rel="stylesheet">


</head>