<?php
include(__DIR__ .  '/../routes/functions.php');
$is_logged_in = false;

// Step 1: Try to get an existing school record
$stmt = $pdo->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
$stmt->execute();
$school = $stmt->fetch(PDO::FETCH_ASSOC);

// Step 2: If no record exists, create one with a default name
if (!$school) {
    $default_name = 'Tauheed Academy';
    $insert_stmt = $pdo->prepare('INSERT INTO schools (name, created_at, updated_at) VALUES (?, NOW(), NOW())');
    $insert_stmt->execute([$default_name]);

    // Fetch again to get the inserted record
    $stmt = $pdo->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
    $stmt->execute();
    $school = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_SESSION['user_session'])) {

    $session = $_SESSION['user_session'];
    $id = $session['id'];
    $email = $session['email'];
    $user_type = $session['user_type'];

    if ($id) {
        if ($user_type === 'student') {
            $stmt = $pdo->prepare("SELECT s.*, c.name as class_name, ca.name as arm_name , ic.name as islamiyya_class_name, ica.name as islamiyya_arm_name  
                                   FROM students  s
                                   LEFT JOIN classes c ON c.id = s.class_id 
                                   LEFT JOIN class_arms ca ON ca.id = s.arm_id 
                                   LEFT JOIN islamiyya_classes ic ON ic.id = s.islamiyya_class_id 
                                   LEFT JOIN islamiyya_class_arms ica ON ica.id = s.islamiyya_arm_id 
                                   WHERE s.id = ? AND s.deleted_at IS NULL");
            $stmt->execute([$id]);
        } else if ($user_type === 'teacher') {
            $stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = ?");
            $stmt->execute([$id]);
        } else if ($user_type === 'guardian') {
            $stmt = $pdo->prepare("SELECT * FROM guardians WHERE id = ?");
            $stmt->execute([$id]);
        } else if ($user_type === 'admin') {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
            $stmt->execute([$id]);
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $is_logged_in = true;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo.png') ?>">
    <title><?= $title ?? '' ?> | <?= $school['name'] ?? 'Tauheed Academy' ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
            }
        }

        @keyframes upDown {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-upDown {
            animation: upDown 0.6s infinite alternate;
        }

        table {
            white-space: nowrap;
            overflow-wrap: normal;
            word-break: normal;
        }
    </style>
</head>

<?php
include(__DIR__ . '/./components/success-notification.php');
include(__DIR__ . '/./components/failure-notification.php');



// try {
//     // List of all tables that have deleted_at column
    // $tables = [
    //     'admins',
    //     'schools',
    //     'teachers',
    //     'sections',
    //     'class_arms',
    //     'classes',
    //     'class_class_arms',
    //     'teacher_section',
    //     'subjects',
    //     'class_subjects',
    //     'guardians',
    //     'sessions',
    //     'terms',
    //     'students',
    //     'student_class_records',
    //     'student_term_records',
    //     'results',
    //     'news',
    //     'fees',
    //     'bank_accounts'
    // ];

//     foreach ($tables as $table) {
//         $stmt = $pdo->prepare("UPDATE `$table` SET deleted_at = NULL");
//         $stmt->execute();
//     }

//     echo "All deleted_at values reset successfully.";

// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }


?>