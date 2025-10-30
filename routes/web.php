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
        'url' => "$baseUrl/auth/login.php"
    ],
    'forgot-password' => [
        'url' => "$baseUrl/auth/forgot-password.php"
    ],
    'reset-password' => [
        'url' => "$baseUrl/auth/reset-password.php"
    ],
    'logout' => [
        'url' => "$baseUrl/auth/logout.php"
    ],
    'school-info' => [
        'url' => "$baseUrl/pages/admin/school-info.php"
    ],
    'admin-section' => [
        'url' => "$baseUrl/pages/admin/admin-section-landing.php"
    ],
    'users-management' => [
        'url' => "$baseUrl/pages/admin/users-management/users-management.php"
    ],
    'admin-create' => [
        'url' => "$baseUrl/pages/admin/users-management/admin-create.php"
    ],
    'admin-update' => [
        'url' => "$baseUrl/pages/admin/users-management/admin-update.php"
    ],
    'guardian-create' => [
        'url' => "$baseUrl/pages/admin/users-management/guardian-create.php"
    ],
    'guardian-update' => [
        'url' => "$baseUrl/pages/admin/users-management/guardian-update.php"
    ],
    'teacher-create' => [
        'url' => "$baseUrl/pages/admin/users-management/teacher-create.php"
    ],
    'teacher-update' => [
        'url' => "$baseUrl/pages/admin/users-management/teacher-update.php"
    ],
    'student-create' => [
        'url' => "$baseUrl/pages/admin/users-management/student-create.php"
    ],
    'student-update' => [
        'url' => "$baseUrl/pages/admin/users-management/student-update.php"
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

    'arms-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-management.php"
    ],
    'create-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-create-form.php"
    ],
    'update-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-update-form.php"
    ],

    'sections-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/sections-management.php"
    ],
    'create-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-create-form.php"
    ],
    'update-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-update-form.php"
    ],


];
