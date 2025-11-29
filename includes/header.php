<?php
include(__DIR__ .  '/../routes/functions.php');
$is_logged_in = false;

// Step 1: Try to get an existing school record
$stmt = $conn->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
$stmt->execute();
$result = $stmt->get_result();
$school = $result->fetch_assoc();

// Step 2: If no record exists, create one with a default name
if (!$school) {
    $default_name = 'Tauheed Academy';
    $insert_stmt = $conn->prepare('INSERT INTO schools (name, created_at, updated_at) VALUES (?, NOW(), NOW())');
    $insert_stmt->bind_param('s', $default_name);
    $insert_stmt->execute();

    // Fetch again to get the inserted record
    $stmt = $conn->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
    $stmt->execute();
    $result = $stmt->get_result();
    $school = $result->fetch_assoc();
}

if (isset($_SESSION['user_session'])) {

    $session = $_SESSION['user_session'];
    $id = $session['id'];
    $email = $session['email'];
    $user_type = $session['user_type'];

    if ($id) {
        if ($user_type === 'student') {
            $stmt = $conn->prepare("SELECT students.*, classes.name as class_name, class_arms.name as arm_name  from students left join classes on classes.id = students.class_id left join class_arms on class_arms.id = students.arm_id where students.id = ? and students.deleted_at is null");
        } else if ($user_type === 'teacher') {
            $stmt = $conn->prepare("SELECT * from teachers where id = ?");
        } else if ($user_type === 'guardian') {
            $stmt = $conn->prepare("SELECT * from guardians where id = ?");
        } else if ($user_type === 'admin') {
            $stmt = $conn->prepare("SELECT * from admins where id = ?");
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $is_logged_in = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?> | <?= $school['name'] ?? 'Tauheed Academy' ?></title>
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

?>