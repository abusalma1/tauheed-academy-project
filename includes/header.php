<?php
include(__DIR__ .  '/../routes/functions.php');


// Step 1: Try to get an existing school record
$statement = $connection->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
$statement->execute();
$result = $statement->get_result();
$school = $result->fetch_assoc();

// Step 2: If no record exists, create one with a default name
if (!$school) {
    $default_name = 'Tauheed Academy';
    $insert_stmt = $connection->prepare('INSERT INTO schools (name, created_at, updated_at) VALUES (?, NOW(), NOW())');
    $insert_stmt->bind_param('s', $default_name);
    $insert_stmt->execute();

    // Fetch again to get the inserted record
    $statement = $connection->prepare('SELECT * FROM schools ORDER BY created_at ASC LIMIT 1');
    $statement->execute();
    $result = $statement->get_result();
    $school = $result->fetch_assoc();
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
    </style>
</head>

<?php
include(__DIR__ . '/./components/success-notification.php');
?>