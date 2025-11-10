<?php
include(__DIR__ . "/../routes/functions.php");

if (isset($_SESSION["user_session"])) {
    $_SESSION['success'] = "Logged out successfully!";

    unset($_SESSION["user_session"]);

 
}

header('Location: ' . route('home'));
exit;
