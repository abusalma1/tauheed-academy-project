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
        'url' => "$baseUrl/pages/admin/school-info.php"
    ],
    'users-management' => [
        'url' => "$baseUrl/pages/admin/users-management/users-management.php"
    ],
    'admins-management' => [
        'url' => "$baseUrl/pages/admin/users-management/admins-management.php"
    ],
    'gurdians-management' => [
        'url' => "$baseUrl/pages/admin/users-management/guardians-management.php"
    ],
    'teachers-management' => [
        'url' => "$baseUrl/pages/admin/users-management/teachers-management.php"
    ],
    'students-management' => [
        'url' => "$baseUrl/pages/admin/users-management/students-management.php"
    ],

    'class-arm-section-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/classes-sections-arms-management.php"
    ],
    'classes-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/classes-management.php"
    ],
    'update-class' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-update-form.php"
    ],
    'create-class' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-create-form.php"
    ],

    'update-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-update-form.php"
    ],
    'create-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-management.php"
    ],


    'update-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-update-form.php"
    ],
    'create-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-create-form.php"
    ],


];
