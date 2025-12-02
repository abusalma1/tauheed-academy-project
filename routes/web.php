<?php
include(__DIR__ . '/../config/db-connect.php');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

$host = $_SERVER['HTTP_HOST'];

if ($host === 'localhost' || preg_match('/^192\.168\./', $host)) {
    // adjust this path to match your project folder
    $baseUrl = $protocol . "://" . $host . "/tauheed-academy-project";
} else {
    $baseUrl = $protocol . "://" . $host;
}


$routes = [
    'back' => [
        'url' => $_SESSION['previous_page'] ?? $baseUrl . "/index.php"
    ],
    'home' => [
        'url' => "$baseUrl/index.php"
    ],
    'about' => [
        'url' => "$baseUrl/pages/about.php"
    ],
    'contact' => [
        'url' => "$baseUrl/pages/contact.php"
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

    // non auth news
    'news' => [
        'url' => "$baseUrl/pages/news/"
    ],
    'news-detial' => [
        'url' => "$baseUrl/pages/news/news-detail.php"
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


    //admin news
    'admin-news' => [
        'url' => "$baseUrl/pages/admin/news/"
    ],

    'post-news' => [
        'url' => "$baseUrl/pages/admin/news/post-news.php"
    ],
    'admin-news-detial' => [
        'url' => "$baseUrl/pages/admin/news/news-detail.php"
    ],
    'update-news-post' => [
        'url' => "$baseUrl/pages/admin/news/update-news-post.php"
    ],
    'delete-news-post' => [
        'url' => "$baseUrl/pages/admin/news/delete-news.php"
    ],

    // users 

    'users-management' => [
        'url' => "$baseUrl/pages/admin/users-management/"
    ],
    'update-user-password' => [
        'url' => "$baseUrl/pages/admin/users-management/update-user-password.php"
    ],
    'view-user-details' => [
        'url' => "$baseUrl/pages/admin/users-management/user-details.php"
    ],
    'delete-user' => [
        'url' => "$baseUrl/pages/admin/users-management/delete-user.php"
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
        'url' => "$baseUrl/pages/admin/class-arm-section-management/"
    ],

    // classes
    'classes-management' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/index.php"
    ],
    'update-class' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/class-update.php"
    ],
    'create-class' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/class-create.php"
    ],
    'delete-class' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/delete-class.php"
    ],
    'assing-class-teacher' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/class-teacher.php"
    ],
    'class-performance' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/classes-records.php"
    ],

    // class arms

    'arms-management' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/class-arms/index.php"
    ],
    'create-class-arm' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/class-arms/class-arm-create.php"
    ],
    'update-class-arm' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/class-arms/class-arm-update.php"
    ],
    'delete-class-arm' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/class-arms/delete-class-arm.php"
    ],

    // sections

    'sections-management' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/sections/index.php"
    ],
    'create-section' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/sections/section-create.php"
    ],
    'update-section' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/sections/section-update.php"
    ],
    'delete-section' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/sections/delete-section.php"
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
    'delete-subject' => [
        'url' => "$baseUrl/pages/admin/subjects-management/delete-subject.php"
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
    'delete-term' => [
        'url' => "$baseUrl/pages/admin/term-session-management/delete-term.php"
    ],
    'delete-session' => [
        'url' => "$baseUrl/pages/admin/term-session-management/delete-session.php"
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
    'view-subject-result' => [
        'url' => "$baseUrl/pages/results-management/view-subject-result.php"
    ],
    'student-result' => [
        'url' => "$baseUrl/pages/results-management/student-results.php"
    ],


    //  guardians
    'my-children' => [
        'url' => "$baseUrl/pages/guardian/"
    ],


    //  profile
    'profile' => [
        'url' => "$baseUrl/pages/profile/index.php"
    ],
    'update-profile' => [
        'url' => "$baseUrl/pages/profile/user-update-profile.php"
    ],
    'update-profile-password' => [
        'url' => "$baseUrl/pages/profile/user-change-password.php"
    ],

    //  admin fees
    'fees-management' => [
        'url' => "$baseUrl/pages/admin/fees/"
    ],
    'admin-fees' => [
        'url' => "$baseUrl/pages/admin/fees/fees.php"
    ],
    'fees-assginment' => [
        'url' => "$baseUrl/pages/admin/fees/fees-assignment.php"
    ],
    'submit-fees' => [
        'url' => "$baseUrl/pages/admin/fees/submit-fees.php"
    ],
    'delete-bank-account' => [
        'url' => "$baseUrl/pages/admin/fees/delete-bank-account.php"
    ],
    'add-bank-account' => [
        'url' => "$baseUrl/pages/admin/fees/add-bank-account.php"
    ],
    'update-bank-account' => [
        'url' => "$baseUrl/pages/admin/fees/update-bank-account.php"
    ],
    'bank-accounts' => [
        'url' => "$baseUrl/pages/admin/fees/bank-accounts.php"
    ],


    // class teachers

    'my-class' => [
        'url' => "$baseUrl/pages/teachers/my-class.php"
    ],
    'class-student-detials' => [
        'url' => "$baseUrl/pages/teachers/class-student-detials.php"
    ],
    'update-class-student-password' => [
        'url' => "$baseUrl/pages/teachers/update-student-password.php"
    ],
    'class-broadsheet-by-session' => [
        'url' => "$baseUrl/pages/teachers/class-broadsheet-by-session.php"
    ],
    'class-broadsheet-by-term' => [
        'url' => "$baseUrl/pages/teachers/class-broadsheet-by-term.php"
    ],

];
