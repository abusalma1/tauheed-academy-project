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
    'print' => [
        'url' => "$baseUrl/config/print.php"
    ],
    '404' => [
        'url' => "$baseUrl/404.php"
    ],
    '403' => [
        'url' => "$baseUrl/403.php"
    ],
    'current' => [
        'url' => $protocol . "://" . $host . $_SERVER['REQUEST_URI']
    ],

    'home' => [
        'url' => $baseUrl
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

    'admin-management' => [
        'url' => "$baseUrl/pages/admin/users-management/admins/"
    ],
    'admin-create' => [
        'url' => "$baseUrl/pages/admin/users-management/admins/create.php"
    ],
    'admin-update' => [
        'url' => "$baseUrl/pages/admin/users-management/admins/update.php"
    ],
    'upload-admin-picture' => [
        'url' => "$baseUrl/pages/admin/users-management/admins/upload-picture.php"
    ],


    // guardian
    'guardian-management' => [
        'url' => "$baseUrl/pages/admin/users-management/guardians/"
    ],
    'guardian-create' => [
        'url' => "$baseUrl/pages/admin/users-management/guardians/create.php"
    ],
    'guardian-update' => [
        'url' => "$baseUrl/pages/admin/users-management/guardians/update.php"
    ],
    'upload-guardian-picture' => [
        'url' => "$baseUrl/pages/admin/users-management/guardians/upload-picture.php"
    ],

    // teachers
    'teacher-management' => [
        'url' => "$baseUrl/pages/admin/users-management/teachers/"
    ],
    'teacher-create' => [
        'url' => "$baseUrl/pages/admin/users-management/teachers/create.php"
    ],
    'teacher-update' => [
        'url' => "$baseUrl/pages/admin/users-management/teachers/update.php"
    ],
    'upload-teacher-picture' => [
        'url' => "$baseUrl/pages/admin/users-management/teachers/upload-picture.php"
    ],

    // students
    'student-management' => [
        'url' => "$baseUrl/pages/admin/users-management/students/"
    ],
    'student-create' => [
        'url' => "$baseUrl/pages/admin/users-management/students/create.php"
    ],
    'student-update' => [
        'url' => "$baseUrl/pages/admin/users-management/students/update.php"
    ],
    'upload-student-picture' => [
        'url' => "$baseUrl/pages/admin/users-management/students/upload-picture.php"
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
    // class records

    'class-performance' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/history/classes-records.php"
    ],
    'admin-class-broadsheet-by-session' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/history/class-broadsheet-by-session.php"
    ],
    'admin-class-broadsheet-by-term' => [
        'url' => "$baseUrl/pages/admin/class-arm-section-management/classes/history/class-broadsheet-by-term.php"
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
    'update-term-status' => [
        'url' => "$baseUrl/pages/admin/term-session-management/update-term-status.php"
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


    // admin resutls results
    'admin-results-management' => [
        'url' => "$baseUrl/pages/admin/results-management/"
    ],
    'admin-upload-results' => [
        'url' => "$baseUrl/pages/admin/results-management/upload-results.php"
    ],
    'admin-view-subject-result' => [
        'url' => "$baseUrl/pages/admin/results-management/view-subject-result.php"
    ],
    'admin-student-result' => [
        'url' => "$baseUrl/pages/admin/results-management/student-results.php"
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
    'update-profile-picture' => [
        'url' => "$baseUrl/pages/profile/upload-picture.php"
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



    // ISLAMIYYA SECTION

    'islamiyya-class-arm-section-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/"
    ],

    // islamiyya classes
    'islamiyya-classes-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/index.php"
    ],
    'update-islamiyya-class' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/class-update.php"
    ],
    'create-islamiyya-class' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/class-create.php"
    ],
    'delete-islamiyya-class' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/delete-class.php"
    ],
    'assing-islamiyya-class-teacher' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/class-teacher.php"
    ],



    // islamiyya admin resutls
    'admin-islamiyya-results-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/results-management/"
    ],
    'admin-upload-islamiyya-results' => [
        'url' => "$baseUrl/pages/admin/islamiyya/results-management/upload-results.php"
    ],
    'admin-view-islamiyya-subject-result' => [
        'url' => "$baseUrl/pages/admin/islamiyya/results-management/view-subject-result.php"
    ],
    'admin-student-islamiyya-result' => [
        'url' => "$baseUrl/pages/admin/islamiyya/results-management/student-results.php"
    ],

    //islamiyya  subjects

    'islamiyya-subjects-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/subjects-management/"
    ],
    'create-islamiyya-subject' => [
        'url' => "$baseUrl/pages/admin/islamiyya/subjects-management/subject-create.php"
    ],
    'update-islamiyya-subject' => [
        'url' => "$baseUrl/pages/admin/islamiyya/subjects-management/subject-update.php"
    ],
    'delete-islamiyya-subject' => [
        'url' => "$baseUrl/pages/admin/islamiyya/subjects-management/delete-subject.php"
    ],
    'assing-islamiyya-subject-teacher' => [
        'url' => "$baseUrl/pages/admin/islamiyya/subjects-management/subject-teacher.php"
    ],


    // islamiyya class records

    'islamiyya-class-performance' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/history/classes-records.php"
    ],
    'admin-islamiyya-class-broadsheet-by-session' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/history/class-broadsheet-by-session.php"
    ],
    'admin-islamiyya-class-broadsheet-by-term' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/classes/history/class-broadsheet-by-term.php"
    ],

    // islamiyya class arms

    'islamiyya-arms-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/class-arms/index.php"
    ],
    'create-islamiyya-class-arm' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/class-arms/class-arm-create.php"
    ],
    'update-islamiyya-class-arm' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/class-arms/class-arm-update.php"
    ],
    'delete-islamiyya-class-arm' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/class-arms/delete-class-arm.php"
    ],

    // islamiyya sections

    'islamiyya-sections-management' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/sections/index.php"
    ],
    'create-islamiyya-section' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/sections/section-create.php"
    ],
    'update-islamiyya-section' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/sections/section-update.php"
    ],
    'delete-islamiyya-section' => [
        'url' => "$baseUrl/pages/admin/islamiyya/class-arm-section-management/sections/delete-section.php"
    ],


    // class teachers

    'my-islamiyya-class' => [
        'url' => "$baseUrl/pages/teachers/islamiyya/my-class.php"
    ],

    'islamiyya-class-broadsheet-by-session' => [
        'url' => "$baseUrl/pages/teachers/islamiyya/class-broadsheet-by-session.php"
    ],
    'islamiyya-class-broadsheet-by-term' => [
        'url' => "$baseUrl/pages/teachers/islamiyya/class-broadsheet-by-term.php"
    ],


    // islamiyya results
    'islamiyya-results-management' => [
        'url' => "$baseUrl/pages/results-management/islamiyya/"
    ],
    'upload-islamiyya-results' => [
        'url' => "$baseUrl/pages/results-management/islamiyya/upload-results.php"
    ],
    'view-islamiyya-subject-result' => [
        'url' => "$baseUrl/pages/results-management/islamiyya/view-subject-result.php"
    ],
    'student-islamiyya-result' => [
        'url' => "$baseUrl/pages/results-management/islamiyya/student-results.php"
    ],


    // fees
    'admin-islamiyya-fees' => [
        'url' => "$baseUrl/pages/admin/fees/islamiyya-fees.php"
    ],
    'islamiyya-fees-assignment' => [
        'url' => "$baseUrl/pages/admin/fees/islamiyya-fees-assignment.php"
    ],
];
