<?php
session_start();
include('./config/db-connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tauheed Academy</title>
</head>

<body>

    <header>
        <h1>Tauheed Academy</h1>
        <div>
            <?php if ($_SESSION['user_id'] && $_SESSION['user_email']) :  ?>
                <a href="./auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="./auth/login.php">Login</a>
                <a href="./auth/register.php">Register</a>
            <?php endif; ?>

        </div>
    </header>