<?php
include(__DIR__ . '/../config/db-connect.php');
$baseUrl = BASE_URL;

$routes = [
    'home' => [
        'url' => "$baseUrl/index.php"
    ],
    'about' => [
        'url' => "$baseUrl/pages/about.php"
    ],
    'academics' => [
        'url' => "$baseUrl/pages/academics.php"
    ],
    'admission' => [
        'url' => "$baseUrl/pages/admissions.php"
    ],
    'fees' => [
        'url' => "$baseUrl/pages/fees.php"
    ],
    'gallery' => [
        'url' => "$baseUrl/pages/gallery.php"
    ],
    'staff' => [
        'url' => "$baseUrl/pages/staff.php"
    ],
    'timetable' => [
        'url' => "$baseUrl/pages/timetable.php"
    ],
    'uniform' => [
        'url' => "$baseUrl/pages/uniform.php"
    ],
    'login' => [
        'url' => " $baseUrl/auth/login.php"
    ],
    'forgot-password' => [
        'url' => " $baseUrl/auth/forgot-password.php"
    ],
    'reset-password' => [
        'url' => " $baseUrl/auth/reset-password.php"
    ],
    'logout' => [
        'url' => " $baseUrl/auth/logout.php"
    ],
    'school-info' => [
        'url' => "$baseUrl/pages/school-info.php"
    ],


];
