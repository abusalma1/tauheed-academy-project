<?php
include(__DIR__ . '/../config/db-connect.php');
$baseUrl = BASE_URL;

$routes = [
    'back' => [
        'url' => $_SESSION['previous_page']
    ],
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

    // auth 

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

    // admin section 

    'school-info' => [
        'url' => "$baseUrl/pages/admin/school-info.php"
    ],
    'admin-section' => [
        'url' => "$baseUrl/pages/admin/"
    ],

    // users 

    'users-management' => [
        'url' => "$baseUrl/pages/admin/users-management/"
    ],

    // admin 

    'admin-create' => [
        'url' => "$baseUrl/pages/admin/users-management/admin-create.php"
    ],
    'admin-update' => [
        'url' => "$baseUrl/pages/admin/users-management/admin-update.php"
    ],

    // guardian

    'guardian-create' => [
        'url' => "$baseUrl/pages/admin/users-management/guardian-create.php"
    ],
    'guardian-update' => [
        'url' => "$baseUrl/pages/admin/users-management/guardian-update.php"
    ],

    // teachers

    'teacher-create' => [
        'url' => "$baseUrl/pages/admin/users-management/teacher-create.php"
    ],
    'teacher-update' => [
        'url' => "$baseUrl/pages/admin/users-management/teacher-update.php"
    ],

    // students

    'student-create' => [
        'url' => "$baseUrl/pages/admin/users-management/student-create.php"
    ],
    'student-update' => [
        'url' => "$baseUrl/pages/admin/users-management/student-update.php"
    ],

    // classes, sections & class arms 

    'class-arm-section-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/"
    ],

    // classes
    'classes-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/classes-management.php"
    ],
    'update-class' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-update.php"
    ],
    'create-class' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-create.php"
    ],
    'assing-class-teacher' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-teacher.php"
    ],

    // class arms

    'arms-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-management.php"
    ],
    'create-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-create.php"
    ],
    'update-class-arm' => [
        'url' => "$baseUrl/pages/admin/classes-management/class-arm-update.php"
    ],

    // sections

    'sections-management' => [
        'url' => "$baseUrl/pages/admin/classes-management/sections-management.php"
    ],
    'create-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-create.php"
    ],
    'update-section' => [
        'url' => "$baseUrl/pages/admin/classes-management/section-update.php"
    ],

    // subjects

    'subjects-management' => [
        'url' => "$baseUrl/pages/admin/subjects-management/"
    ],
    'create-subject' => [
        'url' => "$baseUrl/pages/admin/subjects-management/subject-create.php"
    ],
    'update-subject' => [
        'url' => "$baseUrl/pages/admin/subjects-management/subject-update.php"
    ],
    'assing-subject-teacher' => [
        'url' => "$baseUrl/pages/admin/subjects-management/subject-teacher.php"
    ],

    // Terms & Sessions

    'term-session-management' => [
        'url' => "$baseUrl/pages/admin/term-session-management/"
    ],
    'create-session' => [
        'url' => "$baseUrl/pages/admin/term-session-management/session-create.php"
    ],
    'update-session' => [
        'url' => "$baseUrl/pages/admin/term-session-management/session-update.php"
    ],
    'create-term' => [
        'url' => "$baseUrl/pages/admin/term-session-management/term-create.php"
    ],
    'update-term' => [
        'url' => "$baseUrl/pages/admin/term-session-management/term-update.php"
    ],


    // session & terms transistions

    'promotion' => [
        'url' => "$baseUrl/pages/admin/session-term-transtion.php"
    ],




    // results
    'results-management' => [
        'url' => "$baseUrl/pages/results-management/"
    ],
    'upload-results' => [
        'url' => "$baseUrl/pages/results-management/upload-results.php"
    ],
    'student-result' => [
        'url' => "$baseUrl/pages/results-management/student-results.php"
    ],


    // 
    'my-children' => [
        'url' => "$baseUrl/pages/guardian/"
    ]
  

];
